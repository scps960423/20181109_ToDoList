<?php
if (!isset($_SESSION)) {
    session_start();
 }
function _dbconnect(){
	$db = "oci:dbname=(description=(address=(protocol=tcp)(host=140.117.69.58)(port=1521))(connect_data=(sid=ORCL)));charset=utf8";
	$username = "Group17";
	$password = "group171717";
	try {
	    $conn = new PDO($db, $username, $password);
	} catch (PDOException $e) {
	    echo $e->getMessage();
	}
	return $conn;
}

function _SQLOpen($dbcon,$query)
{
	try {
		$result = $dbcon->query($query);
	} catch (PDOException $e){
		$result = $e->getMessage();
	}
	return $result;
}

function _SQLExecu($dbcon,$query)
{
	try {
		$result = $dbcon->exec($query);
	} catch (PDOException $e){
		$result = $e->getMessage();
	}	
	echo $result;
}
global $db;
$db = _dbconnect();
date_default_timezone_set('Asia/Taipei');

if($_POST['submit'])
{
	_Login($_POST['account'],$_POST['password']);
}

function _Login($uno,$pwd)
{
	$query = "SELECT * FROM TB_USER WHERE UNO = '$uno' AND PWD = '$pwd'";
	$result = $db->query($query)->fetchAll();
	if(count($result) > 0){
		$_SESSION['UNO'] = $_POST['account'];
      	header("../index.html");
	}else{
		echo " 登入失敗 ";
	}
}

function _AccountCheck($uno)
{
	$query = "SELECT * FROM TB_USER WHERE UNO = '$uno'";
	$stid = _SQLOpen($GLOBALS['db'],$query);
	if($stid->columnCount() > 0){
		return 1;
	}else{
		return 0;
	}
}	
function _AccountCreate($uno,$pwd,$uname,$email)
{
	$query = "SELECT * FROM TB_USER WHERE UNO = '$uno'";
	$stid = _SQLOpen($GLOBALS['db'],$query);
	if($stid->columnCount() > 0){
		echo "Account already exits!";
	}else{
		$query = "INSERT INTO TB_USER VALUES ('$uno','$pwd','$uname','$email')";
		$stid = _SQLExecu($GLOBALS['db'],$query);
	}
}
function _GroupSelect($uno){
	$query = "SELECT * FROM TB_GROUP WHERE UNO = '$uno'";
	$stid = _SQLOpen($GLOBALS['db'],$query);
	return $stid;
}
function _GroupCreate($uno,$gtitle){
	$query = "INSERT INTO TB_GROUP(UNO,TITLE) VALUES ('$uno','$gtitle')";
	$stid = _SQLExecu($GLOBALS['db'],$query);
}
function _GroupEdit($uno,$gno,$gtitle){
	$query = "UPDATE TB_GROUP SET TITLE = '$gtitle' WHERE UNO = '$uno' AND GNO = '$gno' ";
	$stid = _SQLExecu($GLOBALS['db'],$query);
}
function _GroupDelete($uno,$gno){
	$query = "DELETE TB_GROUP WHERE UNO = '$uno' AND GNO = '$gno' ";
	$stid = _SQLExecu($GLOBALS['db'],$query);
}

function _ListSelect($uno,$gno){
	$query = "SELECT * FROM TB_LIST WHERE UNO = '$uno' AND GNO = '$gno'";
	$stid = _SQLOpen($GLOBALS['db'],$query);
	return $stid;
}
function _ListCreate($uno,$gno,$ltitle){
	$datetime = date ("Y-m-d H:i:s");
	$query = "INSERT INTO TB_LIST(UNO,GNO,TITLE,CREATEDAY) VALUES ('$uno','$gno','$ltitle','$datetime')";
	$stid = _SQLExecu($GLOBALS['db'],$query);
}
function _ListEditTitle($uno,$gno,$lno,$ino,$ltitle){
	$query = "UPDATE TB_LIST SET TITLE = '$ltitle' WHERE UNO = '$uno' AND GNO = '$gno' AND LNO = '$lno' AND INO = '$ino'";
	$stid = _SQLExecu($GLOBALS['db'],$query);
}
function _ListDelete($uno,$gno,$lno){
	$query = "DELETE TB_LIST WHERE UNO = '$uno' AND GNO = '$gno' AND LNO = '$lno'";
	$stid = _SQLExecu($GLOBALS['db'],$query);
	$query = "DELETE SHARE WHERE UNO = '$uno' AND GNO = '$gno' AND LNO = '$lno'";
	$stid = _SQLExecu($GLOBALS['db'],$query);
}

function _ItemSelect($uno,$gno,$lno){
	$query = "SELECT * FROM TB_Item WHERE UNO = '$uno' AND GNO = '$gno' AND LNO = '$lno'";
	$stid = _SQLOpen($GLOBALS['db'],$query);
	return $stid;
}
function _ItemCreate($uno,$gno,$lno,$ititle,$iconten){
	$datetime = date ("Y-m-d H:i:s");
	$query = "INSERT INTO TB_Item(UNO,GNO,LNO,TITLE,CREATEDAY) VALUES ('$uno','$gno','$LNO','$ltitle','$datetime')";
	$stid = _SQLExecu($GLOBALS['db'],$query);
}
function _ItemEditTitle($uno,$gno,$lno,$ititle){
	$query = "UPDATE TB_Item SET TITLE = '$ititle' WHERE UNO = '$uno' AND GNO = '$gno' AND LNO = '$lno'";
	$stid = _SQLExecu($GLOBALS['db'],$query);
}
function _ItemEditContent($uno,$gno,$lno,$iconten){
	$query = "UPDATE TB_Item SET CONTENT = '$iconten' WHERE UNO = '$uno' AND GNO = '$gno' AND LNO = '$lno'";
	$stid = _SQLExecu($GLOBALS['db'],$query);
}
function _ItemDelete($uno,$gno,$lno){
	$query = "DELETE TB_Item WHERE UNO = '$uno' AND GNO = '$gno' AND LNO = '$lno'";
	$stid = _SQLExecu($GLOBALS['db'],$query);
}

// function _ItemCreate($uno){}
// function _ItemEdit($uno){}
// function _ItemDelete($uno){}

