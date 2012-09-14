<?php

class MyException extends Exception {
	private $error;

    public function __construct($message, $subMessage="", $code = 0) {
        // some code

    	$this->error = $subMessage;
        parent::__construct($message, $code);
    }

    // custom string representation of object
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}: {$this->error}\n";
    }

    public function customFunction() {
        echo "A custom function for this type of exception\n";
    }
    public function htmlView() {
    	?>
    	<table align="center" border="1" cellspacing="0" style="background:white;color:black;width:80%;">
		<tr><th colspan=2>Database Error</th></tr>
		<tr><td align="right" valign="top">Message:</td><td><?php echo $this->message; ?></td></tr>
		<?php if(!empty($this->error)) echo '<tr><td align="right" valign="top" nowrap>Error:</td><td>'.$this->error.'</td></tr>'; ?>
        <?php if(!empty($this->code)) echo '<tr><td align="right" valign="top" nowrap>Code:</td><td>'.$this->code.'</td></tr>'; ?>
		<tr><td align="right">Date:</td><td><?php echo date("l, F j, Y \a\\t g:i:s A"); ?></td></tr>
		<?php if(!empty($_SERVER['REQUEST_URI'])) echo '<tr><td align="right">Script:</td><td><a href="'.$_SERVER['REQUEST_URI'].'">'.$_SERVER['REQUEST_URI'].'</a></td></tr>'; ?>
		<?php if(!empty($_SERVER['HTTP_REFERER'])) echo '<tr><td align="right">Referer:</td><td><a href="'.$_SERVER['HTTP_REFERER'].'">'.$_SERVER['HTTP_REFERER'].'</a></td></tr>'; ?>
		</table>
		<?php
	}

}

if ($testing){
    include_once "..\config.php";
include_once ('basic_functions.php');

function head() {
    doHtmlHeaderLogout('Exception test');
 }

function foot() {
    doHtmlFooter();
        /*
 echo "</body>
        </html>";
        */
}

function a() {

    throw new MyException("Database Error", "Test MyException error", 100);

}

head();
try {

    a();
    echo "Test Failed";
} 
catch (MyException $e) {

    echo $e;
    echo $e->htmlView();
    echo "Test DONE testing:".$testing;
}
foot();
}
?>