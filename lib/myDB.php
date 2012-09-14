<?php
# Name: myDB.php
# File Description: MySQL Singleton Class to allow easy and clean access to common mysqli commands
# Author: heikki leppänen
# Web: 
# Update: 2012-08-08
# Version: 1.0
# Copyright HJL-Digitekniikka Oy


//require("config.inc.php");
//$db = MyDb::init(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);

//$db = MyDb::init();

include_once ('MyException.php');
###################################################################################################
###################################################################################################
###################################################################################################
class MyDb{

	// Store the single instance of MyDb
	private static $instance;

	private	$server   = ""; //database server
	private	$user     = ""; //database login name
	private	$pass     = ""; //database login password
	private	$database = ""; //database name

	private	$error = 0;

	#######################
	//number of rows affected by SQL query
	public	$affected_rows = 0;

	private	$link_id = 0;
	private	$query_id = 0;
	private $query_string;


#-#############################################
# desc: constructor
private function __construct($server=null, $user=null, $pass=null, $database=null){
	// error catching if not passed in
	if($server==null || $user==null || $database==null){
		$this->oops("MyDb information must be passed in when the object is first created.");
	}

	$this->server=$server;
	$this->user=$user;
	$this->pass=$pass;
	$this->database=$database;
	$this->connect();
	mysqli_set_charset($this->link_id, 'utf8');

}#-#constructor()


#-#############################################
# desc: singleton declaration
public static function init($server=null, $user=null, $pass=null, $database=null){
	if (!self::$instance){ 
		self::$instance = new MyDb($server, $user, $pass, $database); 
	} 

	return self::$instance; 
}#-#obtain()


#-#############################################
# desc: connect and select database using vars above
# Param: $new_link can force connect() to open a new link, even if mysqli_connect() was called before with the same parameters
 function connect(){
	$this->link_id=@mysqli_connect($this->server,$this->user,$this->pass, $this->database);
	if (!$this->link_id){//open failed
		throw new MyException("Database error", mysqli_connect_error(), mysqli_connect_errno());
	}

	// unset the data so it can't be dumped
	$this->server='';
	$this->user='';
	$this->pass='';
	$this->database='';
	@mysqli_autocommit( $this->link_id, FALSE);
}#-#connect()



#-#############################################
# desc: close the connection
public function close(){
	if(!@mysqli_close($this->link_id)){
		$this->oops("Connection close failed.");
	}
}#-#close()


#-#############################################
# Desc: escapes characters to be mysql ready
# Param: string
# returns: string
public function escape($string){
	if(get_magic_quotes_runtime()) $string = stripslashes($string);
	return @mysqli_real_escape_string($this->link_id,$string);
}#-#escape()

#-#############################################
# Desc: executes SQL commit to an open connection
# returns: NONE
public function commit() {
	@mysqli_commit($this->link_id);
}

#-#############################################
# Desc: executes SQL rollback to an open connection
# returns: NONE
public function rollback() {
	@mysqli_rollback($this->link_id);
}


#-#############################################
# Desc: executes SQL query to an open connection
# Param: (MySQL query) to execute
# returns: (query_id) for fetching results etc
public function query($sql){
	// do query
	$this->query_id = @mysqli_query($this->link_id, $sql);

	if (!$this->query_id){
		$this->oops("<b>MySQL Query fail:</b> $sql");
		return 0;
	}
	$query_string = $sql;
	$this->affected_rows = @mysqli_affected_rows($this->link_id);

	return $this->query_id;
}#-#query()

#-#############################################
# desc: return last excecuted query
# 
function last_query() {
	return $query_string;
}

#-#############################################
# desc: does a query, fetches the first row only, frees resultset
# param: (MySQL query) the query to run on server
# returns: array of fetched results
public function queryFirst($query_string){
	$query_id = $this->query($query_string);
	$out = $this->fetch($query_id);

	return $out;
}#-#query_first()


#-#############################################
# desc: fetches and returns results one line at a time
# param: query_id for mysql run. if none specified, last used
# return: (array) fetched record(s)
public function fetch($query_id=-1){
	// retrieve row
	if ($query_id!=-1){
		$this->query_id=$query_id;
	}

	if (isset($this->query_id)){
		$record = @mysqli_fetch_assoc($this->query_id);
	}else{
		$this->oops("Invalid query_id: <b>$this->query_id</b>. Records could not be fetched.");
	}

	return $record;
}#-#fetch()


#-#############################################
# desc: returns all the results (not one row)
# param: (MySQL query) the query to run on server
# returns: assoc array of ALL fetched results
public function fetchArray($sql){
	$queryId = $this->query($sql);
	$out = array();

	while ($row = $this->fetch($query_id)){
		$out[] = $row;
	}

	return $out;
}#-#fetch_array()


#-#############################################
# desc: does an update query with an array
# param: table, assoc array with data (not escaped), where condition (optional. if none given, all records updated)
# returns: (query_id) for fetching results etc
public function update($table, $data, $where){
	$q="UPDATE `$table` SET ";

	foreach($data as $key=>$val){
		if(strtolower($val)=='null') $q.= "`$key` = NULL, ";
		elseif(strtolower($val)=='now()') $q.= "`$key` = NOW(), ";
        elseif(preg_match("/^increment\((\-?\d+)\)$/i",$val,$m)) $q.= "`$key` = `$key` + $m[1], "; 
		else $q.= "`$key`='".$this->escape($val)."', ";
	}

	$q = rtrim($q, ', ') . ' WHERE '.$where.';';

	return $this->query($q);
}#-#update()

#-#############################################
# desc: does an update query with an array
# param: table, assoc array with data (not escaped), where condition (optional. if none given, all records updated)
# returns: (query_id) for fetching results etc
public function delete($table,  $where){
	$q="DELETE FROM `$table` ";

	$q = $q.' WHERE '.$where.';';

	return $this->query($q);
}#-#update()

#-#############################################
# desc: does an insert query with an array
# param: table, assoc array with data (not escaped)
# returns: id of inserted record, false if error
public function insert($table, $data){
	$q="INSERT INTO `$table` ";
	$v=''; $n='';

	foreach($data as $key=>$val){
		$n.="`$key`, ";
		if(strtolower($val)=='null') $v.="NULL, ";
		elseif(strtolower($val)=='now()') $v.="NOW(), ";
		else $v.= "'".$this->escape($val)."', ";
	}

	$q .= "(". rtrim($n, ', ') .") VALUES (". rtrim($v, ', ') .");";

	if($this->query($q)){
		return mysqli_insert_id($this->link_id);
	}
	else return false;

}#-#insert()


#-#############################################
# desc: throw an error message
# param: [optional] any custom error to display
private function oops($msg=''){
	if(empty($this->link_id)){
		$msg="<b>WARNING:</b> No link_id found. Likely not be connected to database.<br />$msg";
		throw new MyException($msg, @mysqli_connect_error(),  @mysqli_connect_errno());
	}
	throw new MyException($msg, @mysqli_error($this->link_id),  @mysqli_errno($this->link_id));

}#-#oops()


}//CLASS MyDb
###################################################################################################
/* Fuction test area
*/
$dbtesting=1;

if ($dbtesting){
    include_once "..\config.php";
	include_once ('basic_functions.php');

function head() {
    doHtmlHeaderLogout('MyDb test');
 }

function foot() {
    doHtmlFooter();
}


head();
try {
	$db = MyDb::init('localhost', 'hleppane', '1rene24','eduskuntapuheet');

	# First query
#	$q = 'SELECT nimi from  edustajat WHERE vaalipiiri = \'pirkanmaan\' ORDER BY \'nimi\'';
	$q = 'SELECT nimi from  edustajat WHERE puolue = \'sd\' ORDER BY nimi';

	echo "<p></p>";

	echo "<p>Query test: $q</p>";
	$db->query($q);
	while ($r = $db->fetch()) {
		echo "<p>".$r['nimi']."</p>";
	}

	echo "<p>Insert</p>";
	$i = array("nimi"=>'Erkki Etevä', 'vaalipiiri'=>'Vaasan','puolue'=>'kok');
	$db->insert('edustajat', $i);

	echo "<p>Update</p>";
	$u = array('puolue'=>'sd');
	$db->update('edustajat', $u, 'nimi=\'Erkki Etevä\'');

	echo "<p>Delete</p>";

	$db->delete('edustajat', 'nimi=\'Erkki Etevä\'');

	$db->commit();


} 
catch (MyException $e) {
    echo $e->htmlView();
}
echo "<p>Test DONE!</p>";
foot();
}
?>
