<?php

//code by nhancm

date_default_timezone_set('Asia/Saigon');

$host = "localhost";
$username = "modskin";
$password = "bp705sOi";
$database = "modskin_database";
$table_err = "tbl_error";
$table_ins = "tbl_install";
$time = date("Y-m-d H:i:s");

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}

$name = !empty($_GET["name"]) ? $_GET["name"] : "x";
$skinname = !empty($_GET["skinname"]) ? trim($_GET["skinname"]) : "";
$hash = !empty($_GET["hash"]) ? trim($_GET["hash"]) : "";
$action = !empty($_GET["action"]) ? trim($_GET["action"]) : "";
$note = !empty($_GET["note"]) ? trim($_GET["note"]) : "";

if (md5('secret_@_modskinlol' . date("Y-m-d"))!= $hash) {
	die("Invalid HASH" . "||" . $ip . "||" . $name . "||" . $skinname . "||Your Hash: " . $hash . "!=" . md5('secret_@_modskinlol' . date("Y-m-d")) . "\n" . 'secret_@_modskinlol' . date("Y-m-d"));
} else 
if ($action == "error_skin")
{
	$con = mysql_connect($host,$username,$password);
	if (!$con) {
		die("Could not connect: " . mysql_error());
	} else { //echo "Connect OK"; 
		mysql_set_charset('utf8',$con);
	}

	$db_selected = mysql_select_db($database, $con);

	if (!$db_selected) {    die ('Can\'t use the db : ' . mysql_error());
	} else { //echo "Use the DB OK"; 
	}
				
	if (strlen($skinname)>3) {
		//die($note);
		$result = mysql_query("INSERT INTO $table_err(`name`,`skinname`,`lastupdate`,`ip`, `status`, `note`) VALUES('$name','$skinname','$time','$ip', '0','$note')");
	}	

	if (!$result) { die("lid query: " . mysql_error()); }
	else {
		echo "OK";
	}
	mysql_close($con);
} else 
if ($action == "install_skin")
{
	$con = mysql_connect($host,$username,$password);
	if (!$con) {
		die("Could not connect: " . mysql_error());
	} else { //echo "Connect OK"; 
		mysql_set_charset('utf8',$con);
	}

	$db_selected = mysql_select_db($database, $con);

	if (!$db_selected) {    die ('Can\'t use the db : ' . mysql_error());
	} else { //echo "Use the DB OK"; 
	}
				
	if (strlen($skinname)>3) {
		$check_skinname = mysql_query("select skinname from $table_ins where skinname='$skinname'");
		if(mysql_num_rows($check_skinname)>=1)
		{
			$result = mysql_query("UPDATE $table_ins SET count = count + 1 where skinname='$skinname'");
		} else {
			$result = mysql_query("INSERT INTO $table_ins(`name`,`skinname`,`lastupdate`,`ip`, `count`) VALUES('$name','$skinname','$time','$ip', '1')");
		}
		
	}	

	if (!$result) { die("lid query: " . mysql_error()); }
	else {
		echo "OK";
	}
	mysql_close($con);
}

?>