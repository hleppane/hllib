<?php

/****************************************************************************
 * PHP alrerady logged in function
 * ************************************************************************/  
function doHtmlHeaderLogout($title) {
  // print an HTML header
?>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
    <META HTTP-EQUIV="Expires" CONTENT="-1">
    <title><?php echo $title;?></title>
     <link rel="stylesheet" type="text/css" href="/css/hjl.css">
    <link rel="stylesheet" type="text/css" href="/css/csshorizontalmenu.css" />
    <script type="text/javascript" src="/js/csshorizontalmenu.js"></script>
    <SCRIPT type="text/JavaScript" SRC="/js/AdminUser.js"></SCRIPT>
	<script src="/js/mktree.js" language="JavaScript"></script>

<SCRIPT LANGUAGE="JavaScript">
	function go(tag) {
        parent.main.location.search = tag;
    }

    function logout() {
        top.location.href="/php/logout.php";
    }

//--------------------------------------------------------
// reload navigation page
//---------------------------------------------------------
function ReloadNavigateFrame() {
    parent.navigate.location.reload();
}

//--------------------------------------------------------
// reload main page
//---------------------------------------------------------
function ReloadMainFrame() {
    parent.main.location.reload();
}



</SCRIPT>

 </head>
 <body class="main">
<form>
<!--	<li class="top-menu" style="float:right"><A  HREF="#" onClick="login1('anchor1');return false;" NAME="anchor1" ID="anchor1">Login</A></li> -->
    	<A  HREF="#" style="float:right" onClick="logout();" NAME="anchor1" ID="anchor1">Logout</A> 
</form>


<?php
  if($title) {
    doHtmlHeading($title);
  }
}


/*****************************************************************
 * This is the header for login page
 * ***************************************************************/ 
function do_htmlHeaderLogin($title) {
  // print an HTML header
?>
  <html>
  <head>
    <META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
    <META HTTP-EQUIV="Expires" CONTENT="-1">
    <title><?php echo $title;?></title>
     <link rel="stylesheet" type="text/css" href="/css/hjl.css">
    <link rel="stylesheet" type="text/css" href="/css/csshorizontalmenu.css" />
    <script type="text/javascript" src="/js/csshorizontalmenu.js"></script>
    <SCRIPT LANGUAGE="JavaScript" SRC="/js/PopupWindow.js"></SCRIPT>
    <SCRIPT LANGUAGE="JavaScript" SRC="/js/AnchorPosition.js"></SCRIPT>
    <script type="text/javascript"  src="/js/ajaxXml.js"></script>

 
 </head>
 <body class="main">
<form>
<!--	<li class="top-menu" style="float:right"><A  HREF="#" onClick="login1('anchor1');return false;" NAME="anchor1" ID="anchor1">Login</A></li> -->
    	<A  HREF="#" style="float:right" onClick="login1('anchor1');return false;" NAME="anchor1" ID="anchor1">Login</A> 
</form>

<DIV ID="logindiv1" 
    STYLE="position:absolute;visibility:hidden;background-color:#a8be38;width: 25em; height: 15em; margin:5; border:5px solid blue;">
    <center><h5>Please write login id and password above</h5></center> 
    <form action="javascript:get(document.getElementById('login'));" name="login" id="login"><br>
    <div style="margin-left:2em;width:6em;float:left;">Name: </div><input name="user" size="20"><br><br>
    <div style="margin-left:2em;width:6em; float:left;">Password: </div><input type="password" name="password" size="20"><br><br>
    <div style="margin-left:8em;">
       <input type="submit"  value="Login">
       <input type="button" onClick="loginpopup1.hidePopup();return false;" value="Cancel">
    </div><br>
 <!--       <input type="hidden" name="loginErrorText" value="Login error: xxxxxx xxxxx"> -->
 <!--   <div  style=" border-top:1px solid blue;" id="loginError">Login error: xxxxxx xxxxx</div> -->
       <div  style=" border-top:1px solid blue;" id="loginError">
        </div>
    </form>
</DIV>


<?php
  if($title) {
    doHtmlHeading($title);
  }
}


function doHtmlFooter() {
  // print an HTML footer
 echo "<p>Copyright HJL-Digitekniikka Oy ".strftime("%A %d %B %Y %H:%M")."</p>";
 ?>

  </body>
    <head>
    <META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">  <!-- for IE -->
    </head>
  </html>
<?php
}

function doHtmlHeading($heading) {
  // print heading
?>
  <h3><?php echo $heading;?></h3>
<?php
}

function doHtmlFrames($topMenusEntry) {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
    <META HTTP-EQUIV="Expires" CONTENT="-1">
    <link rel="stylesheet" type="text/css" href="/css/extendeddisc.css" />
    <title>
    </title>
  </head>
  <frameset border="0px" rows="80px,*">
    <?php
    errorLog(printR($topMenusEntry,true));
    echo "<frame src='".$topMenusEntry['a']."' ";
    echo "resize=\"no\" scrolling=\"no\" frameborder=\"0\" marginheight=\"0\" marginwidth=\"0\"/>";
    echo '<frameset border="1px" cols="20%,*">';
    echo '<frame src="'.$topMenusEntry['b'].'" ';
    echo ' name="navigate" scrolling="auto">';
    echo '<frame src="'.$topMenusEntry['c'].'" ';
    echo ' name="main" scrolling="auto">';
    ?>
  </frameset>
  </frameset>
</html>
<?php
}

function displaySiteInfo() {
  // display some marketing info
?>
  <ul>
  <li>Store your bookmarks online with us!</li>
  <li>See what other users use!</li>
  <li>Share your favorite links with others!</li>
  </ul>
  <br><br>
  <center>
  <img width=60% alt="HJL-Digitekniikka picture" src="/images/card.jpg" />
  </center>
<?php
}
function doSelect($label, $id, $valueList, $selected,$error=array()) {
    echo "<div>";
	echo "<label  for=\"$id\">$label";
	echo "</label>";
    echo "<select id=\"$id\" name=\"$id\" style=\"width:11em;\" ";
    global $action;
    if ($action == 'view')
        echo "disabled=\"disabled\"";
    echo ">";
    foreach ($valueList as $key => $value) {
        if ($selected == $key)
            echo "<option value=\"$key\" selected=\"true\">$value</option>";
        else
            echo "<option value=\"$key\">$value</option>";
        echo "\r\n";
    }
	echo "</select>";
    echo "<span class=\"error\">$error[$id]</span>";
    echo "</div>\r\n";
}

function doSelect2($label, $id, $valueList, $selected,$error=array()) {
    echo "<div>";
	echo "<label  for=\"$id\">$label";
	echo "</label>";
	$s =sizeof($valueList)+1;
    echo "<select size =\"".$s."\" id=\"$id\" name=\"$id\" style=\"width:20em;\" ";
    global $action;
    if ($action == 'view')
        echo "disabled=\"disabled\"";
    echo ">";
    foreach ($valueList as $key => $value) {
        if ($selected == $key)
            echo "<option value=\"$key\" selected=\"true\">$value</option>";
        else
            echo "<option value=\"$key\">$value</option>";
        echo "\r\n";
    }
	echo "</select>";
    echo "<span class=\"error\">$error[$id]</span>";
    echo "</div>\r\n";
}

function doHidden($id, $value) {
    echo "<input type=\"hidden\" id=\"$id\" name=\"$id\" value=\"$value\">";
}

function doInput($label, $id, $value, $size,$error) {
    echo "<div>";
	echo "<label  for=\"$id\">$label";
	echo "</label>";
    echo "<input ";
    global $action;
    if ($action == 'view')
        echo "readonly=\"readonly\"";
    echo " id=\"$id\" name=\"$id\" size=\"$size\" value=\"$value\">";
    echo "<span class=\"error\">$error[$id]</span>";
	echo "</div>\r\n";
}

function doTextarea($label, $id, $value, $size,$error) {
    echo "<div>";
	echo "<label  for=\"$id\">$label";
	echo "</label>";
    echo '<textarea rows="'.$size.'" cols="50" ';
    global $action;
    if ($action == 'view')
        echo "readonly=\"readonly\"";
    echo " id=\"$id\" name=\"$id\" >";
    echo $value;
    echo '</textarea>';
    echo "<span class=\"error\">$error[$id]</span>";
	echo "</div>\r\n";
}

function doInputRo($label, $id, $value, $size) {
    echo "<div>";
	echo "<label  for=\"$id\">$label";
	echo "</label>";
    echo "<input style=\"border-style:none;\" ";
    echo "readonly=\"readonly\"";
    echo " id=\"$id\" name=\"$id\" size=\"$size\" value=\"$value\">";
	echo "</div>\r\n";
}

function doInputNumber($label, $id, $value, $size,$error) {
    echo "<div>";
	echo "<label  for=\"$id\">$label";
	echo "</label>";
    echo "<input style=\"text-align:right;\"";
    global $action;
    if ($action == 'view')
        echo "readonly=\"readonly\"";
    echo " id=\"$id\" name=\"$id\" size=\"$size\" value=\"$value\">";
    echo "<span class=\"error\">$error[$id]</span>";
	echo "</div>\r\n";
}

function do_inputNumberRo($label, $id, $value, $size) {
    echo "<div>";
	echo "<label  for=\"$id\">$label";
	echo "</label>";
    echo "<input style=\"text-align:right;border-style:none;\"";
    echo "readonly=\"readonly\"";
    echo " id=\"$id\" name=\"$id\" size=\"$size\" value=\"$value\">";
    echo "<span class=\"error\">$error[$id]</span>";
	echo "</div>\r\n";
}

$num = 0;
function doInputNumber2( $id, $value, $size, $error, $onclick="") {
    global $action;
    global $num;
    echo "<div>";
    echo "<input style=\"text-align:right;\"  onChange=\"$onclick\" ";
    if ($id == "orderSize[]") {
        $numId = strReplace("[]",$num, $id);
        if ($action != 'view')
            echo "onfocus=\"formatNumber($num)\" ";
        $num++;
    } else
        $numId = $id;
    if ($action == 'view')
        echo "readonly=\"readonly\" ";
    echo " id=\"$numId\" name=\"$id\" size=\"$size\" value=\"$value\">";
    echo "<span class=\"error\">$error[$id]</span>";
	echo "</div>\r\n";
}

function doSelectHref($label, $id, $valueList, $selected) {
    global $action;
   echo "<div>";
	echo "<label  for=\"$id\">$label";
	echo "</label>";
    echo "<select id=\"$id\" name=\"$id\" onchange=\"purchaseOpt('".$action."')\" style=\"width:11em;\" ";
    if ($action == 'view')
        echo "disabled=\"disabled\"";
    echo ">";
    foreach ($valueList as $key => $value) {
        if ($selected == $key)
            echo "<option value=\"$key\" selected=\"true\">$value</option>";
        else
            echo "<option value=\"$key\" >$value</option>";
    }
	echo "</select></div>\r\n";
?>
<script type="text/javascript">
    function purchaseOpt(act) {
        var sel = document.getElementById("purchaseOption");
        var option = sel.options[sel.selectedIndex].value;
   alert("/php/adminUsersIndex.php?purchase="+option+"&action="+act);

        window.location.replace("/php/adminUsersIndex.php?purchase="+option+"&action="+act);
    }
</script>
<?php
}

function doSelectSimple($label, $id, $valueList, $selected,$error) {
    echo "<div>";
	echo "<label  for=\"$id\">$label";
	echo "</label>";
    echo "<select id=\"$id\" name=\"$id\" style=\"width:11em;\" ";
    global $action;
    if ($action == 'view')
        echo "disabled=\"disabled\"";
    echo ">";
    foreach ($valueList as $value) {
        if ($selected == $value)
            echo "<option value=\"$value\" selected=\"true\">$value</option>";
        else
            echo "<option value=\"$value\">$value</option>";
        echo "\r\n";
    }
	echo "</select>";
    echo "<span class=\"error\">$error[$id]</span>";
    echo "</div>\r\n";
}


function doCheckbox($label, $id, $valueList, $error) {
    if (empty($valueList)) return;
    echo "<div>";
	echo "<label  for=\"$id\">$label";
	echo "</label>";
	$num=1;
    foreach ($valueList as $key =>$value) {
        echo "<input type=\"checkbox\" ";
        global $action;
        if ($action == 'view')
            echo "disabled=\"disabled\"";
        if ($value)
            echo " checked=checked ";
        echo " id=\"$id\" name=\"".$id."[]\" value=\"$key\"> $key \n";
    }
    echo "<span class=\"error\">  $error[$id]</span>";
    echo "</div>\r\n";
}



function doCheckboxRo($label, $id, $valueList, $error) {
    if (empty($valueList)) return;
    echo "<div>";
	echo "<label  for=\"$id\">$label";
	echo "</label>";
	$num=1;
    foreach ($valueList as $key =>$value) {
        echo "<input type=\"checkbox\" ";
        global $action;
        echo "disabled=\"disabled\"";
        echo " checked=checked ";
        echo " id=\"$id\" name=\"".$id."[]\" value=\"$key\"> $key \n";
    }
    echo "<span class=\"error\">  $error[$id]</span>";
    echo "</div>\r\n";
}
function doRadio($label, $id, $valueList, $val, $error) {
    if (empty($valueList)) return;
    echo "<div>";
	echo "<label  for=\"$id\">$label";
	echo "</label>";
	$num=1;
//	printR($valueList);
//	echo $val;
    foreach ($valueList as $key =>$value) {
        echo "<input type=\"radio\" ";
        global $action;
        if ($action == 'view')
            echo "disabled=\"disabled\"";
        if ($value == $val)
            echo " checked=checked ";
        echo " id=\"$id\" name=\"".$id."\" value=\"$value\"> $key \n";
    }
    echo "<span class=\"error\">  $error[$id]</span>";
    echo "</div>\r\n";
}



function doRadioRo($label, $id, $valueList, $val, $error) {
    if (empty($valueList)) return;
    echo "<div>";
	echo "<label  for=\"$id\">$label";
	echo "</label>";
	$num=1;
    foreach ($valueList as $key =>$value) {
        echo "<input type=\"radio\" ";
        global $action;
        echo "disabled=\"disabled\"";
        if ($value == $val)
            echo " checked=checked ";
        echo " id=\"$id\" name=\"".$id."[]\" value=\"$value\"> $key \n";
    }
    echo "<span class=\"error\">  $error[$id]</span>";
    echo "</div>\r\n";
}

function splitCommaList($strOn, $strAll) {
        $codes = split("[, ;]+", $strOn);
        $cp = split("[, ;]+", $strAll);
        $list = arrayMerge($codes, $cp);
        $result = array();
        foreach ($list as $value) {
            if ($value != "")
               $result[$value] = inArray($value, $codes);
        }
        return $result;
}

function doInputPw($label, $id, $value, $error, $onChange="" ) {
    echo "<div>";
	echo "<label  for=\"$id\">$label";
	echo "</label>";
    echo "<input ";
    global $action;
    if ($action == 'view')
        echo "readonly=\"readonly\" ";
    else
        echo "onChange=\"$onChange\" ";
    echo "type=\"password\" id=\"$id\" name=\"$id\" value=\"$value\">";
    echo"<span class=\"error\">$error[$id]</span>";
	echo "</div>\r\n";
}



function doHtmlURL($url, $name) {
  // output URL as link and br
?>
  <a href="<?php echo $url; ?>"><?php echo $name; ?></a><br />
<?php
}