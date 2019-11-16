<?php
error_reporting(0);
//取出傳達要做的動作之數值
$GLOBALS['set'] = $_GET["set"];


if (!isset($_SESSION)) {
	session_start();
}
function _dbconnect(){
	$dbs = "oci:dbname=(description=(address=(protocol=tcp)(host=140.117.69.58)(port=1521))(connect_data=(sid=ORCL)));charset=utf8";
	$username = "Group17";
	$password = "group171717";
	try {
		$conn = new PDO($dbs, $username, $password);
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
// echo $result;
}
global $db;
$db = _dbconnect();
date_default_timezone_set('Asia/Taipei');

if(isset($_POST['submit_Login']))
{
	_Login($_POST['account'],$_POST['password']);
}

if(isset($_POST['submit_Signup1']))//2
{
	_AccountCreate($_POST['account'],$_POST['password'],$_POST['uname'],$_POST['email']);            
}
if(isset($_POST['submit_Signup2'])){
	header('Location:signIn.php');
}

function _Login($uno,$pwd)
{
	try {	
		$query = "SELECT * FROM TB_USER WHERE UNO = '$uno' AND PWD = '$pwd'";
		$stid = _SQLOpen($GLOBALS['db'],$query);
		$result = $stid->fetchAll();
		if(count($result) > 0){
			$_SESSION['UNO'] = $_POST['account'];
			$_SESSION['UNAME'] = $result[0]['UNAME'];
			header("Location:index.php");
		}else{
			echo '<script type="text/javascript">';
			echo 'alert("帳號或密碼錯誤");';
			echo "location.href = 'signIn.php'";
			echo '</script>';
		}
	} catch (PDOException $e) {
		echo $e->getMessage();
	}
}

function _AccountCreate($uno,$pwd,$uname,$email)
{
	$query = "SELECT * FROM TB_USER WHERE UNO = '$uno'";
	$stid = _SQLOpen($GLOBALS['db'],$query);
	$result = $stid->fetchAll();

	if(count($result) > 0 || trim($uno) == ""|| trim($pwd) == ""|| trim($uname) == ""|| trim($email) == ""){
		echo '<script type="text/javascript">';
		echo 'alert("註冊失敗");';
		echo "location.href = 'signIn.php'";
		echo '</script>';
	}else{
		$query = "INSERT INTO TB_USER VALUES ('$uno','$pwd','$uname','$email')";
		$stid = _SQLExecu($GLOBALS['db'],$query);
		echo '<script type="text/javascript">';
		echo 'alert("註冊成功");'; 
		echo "location.href = 'signIn.php'";    
		echo '</script>';   
	}
}
//判定session是否為空&是否複寫
function _sesisset($get,$session){
	if (isset($get)){
		$session=$get;
	}
	$new_var=$session;
	return $new_var;
}

//ok
function _GroupSelect($uno){
	$query = "SELECT * FROM tb_group WHERE UNO='".$uno."'";
	$stid = _SQLOpen($GLOBALS['db'],$query);
	return $stid;
}
//ok
function _GroupCreate($uno,$gtitle){
	$query = "INSERT INTO TB_GROUP(UNO,TITLE) VALUES ('$uno','$gtitle')";
	echo $query;
	$stid = _SQLExecu($GLOBALS['db'],$query);
	header("location:index.php?SETVIEW=group");
	exit();	
}
//ok
function _GroupEdit($uno,$gno,$gtitle){
	$query = "UPDATE TB_GROUP SET TITLE = '$gtitle' WHERE UNO = '$uno' AND GNO = '$gno' ";
	$stid = _SQLExecu($GLOBALS['db'],$query);
	header("location:index.php?SETVIEW=group");
	exit();	
}
//ok
function _GroupDelete($uno,$gno){
	$query = "DELETE TB_GROUP WHERE UNO = '$uno' AND GNO = '$gno' ";
	$stid = _SQLExecu($GLOBALS['db'],$query);
	if($_SESSION['GNO']==$gno)
	{
		unset($_SESSION['GNO']);
	}
	header("location:index.php?SETVIEW=group");
	exit();	
}
//ok
function _ListSelect($uno,$gno){

	$query = "SELECT * FROM TB_LIST WHERE UNO = '$uno' AND GNO = '$gno'";
	$stid = _SQLOpen($GLOBALS['db'],$query);
	return $stid;
}
//ok
function _ListCreate($uno,$gno,$ltitle){
//echo "到這囉";

	$datetime = _Gettime();
	$query = "INSERT INTO TB_LIST(UNO,GNO,TITLE,CREATEDAY) VALUES ('$uno','$gno','$ltitle','$datetime')";
	$stid = _SQLExecu($GLOBALS['db'],$query);
	header("location:index.php?SETVIEW=list");
	exit();	
}
//ok
function _ListEditTitle($uno,$gno,$lno,$ltitle){
//echo "到這囉";
	$query = "UPDATE TB_LIST SET TITLE = '$ltitle' WHERE UNO = '$uno' AND GNO = '$gno' AND LNO = '$lno' ";
	$stid = _SQLExecu($GLOBALS['db'],$query);
	header("location:index.php?SETVIEW=list");
	exit();	
}
//ok
function _ListDelete($uno,$gno,$lno){
	$query = "DELETE TB_LIST WHERE SNO = '$uno' AND GNO = '$gno' AND LNO = '$lno'";
	$stid = _SQLExecu($GLOBALS['db'],$query);
	if($_SESSION['LNO']==$lno)
	{
		unset($_SESSION['LNO']);
	}
	header("location:index.php?SETVIEW=list");
	exit();	
}

//ok
function _ItemSelect($uno,$gno,$lno){
	$query = "SELECT * FROM TB_ITEM WHERE UNO = '$uno' AND GNO = '$gno' AND LNO = '$lno'";
// echo $query;
// exit():
	$stid = _SQLOpen($GLOBALS['db'],$query);
	return $stid;
}

//ok
function _ItemCreate($uno,$gno,$lno,$content,$author){
	$datetime = _Gettime();
	$query = "INSERT INTO TB_ITEM(UNO,GNO,LNO,CONTENT,CREATEDAY,AUTHOR) VALUES ('$uno','$gno','$lno','$content','$datetime'
	,'$author')";
	$stid = _SQLExecu($GLOBALS['db'],$query);
	header("location:index.php?SETVIEW=item");
	exit();
}
function _bes_ItemCreate($sno,$gno,$lno,$content,$author){
	$datetime = _Gettime();
	$query = "INSERT INTO TB_ITEM(UNO,GNO,LNO,CONTENT,CREATEDAY,AUTHOR) VALUES ('$sno','$gno','$lno','$content','$datetime'
	,'$author')";
	// echo "$query";
	// exit();
	$stid = _SQLExecu($GLOBALS['db'],$query);
	header("location:index.php?SETVIEW=besitem");
	exit();
}
//ok
function _ItemEditContent($uno,$gno,$lno,$ino,$edititem){
	$query = "UPDATE TB_ITEM SET CONTENT = '$edititem' WHERE UNO = '$uno' AND GNO = '$gno' AND LNO = '$lno' AND INO = '$ino' ";
// echo $query;
	$stid = _SQLExecu($GLOBALS['db'],$query);
	header("location:index.php?SETVIEW=item");
	exit();
}
function _bes_ItemEditContent($uno,$gno,$lno,$ino,$edititem){
	$query = "UPDATE TB_ITEM SET CONTENT = '$edititem' WHERE UNO = '$uno' AND GNO = '$gno' AND LNO = '$lno' AND INO = '$ino' ";
// echo $query;
	$stid = _SQLExecu($GLOBALS['db'],$query);
	header("location:index.php?SETVIEW=besitem");
	exit();
}
//ok
function _ItemDelete($uno,$gno,$lno,$ino){
	$query = "DELETE TB_ITEM WHERE UNO = '$uno' AND GNO = '$gno' AND LNO = '$lno' AND INO= '$ino' ";
	$stid = _SQLExecu($GLOBALS['db'],$query);
	header("location:index.php?SETVIEW=item");
	exit();
}
function _bes_ItemDelete($uno,$gno,$lno,$ino){
	$query = "DELETE TB_ITEM WHERE UNO = '$uno' AND GNO = '$gno' AND LNO = '$lno' AND INO= '$ino' ";
	$stid = _SQLExecu($GLOBALS['db'],$query);
	header("location:index.php?SETVIEW=besitem");
	exit();
}

//ok
function _ListInsertShare($uno,$gno,$lno,$sno){
	$query = "INSERT INTO TB_SHARE(UNO,GNO,LNO,SNO) VALUES ('$uno','$gno','$lno','$sno')";
	$stid = _SQLExecu($GLOBALS['db'],$query);
	header("location:index.php?SETVIEW=beslist");
	exit();	
}

//ok
function _BEShareselect($uno){
	$query = "SELECT * FROM TB_SHARE s LEFT JOIN TB_LIST l ON s.GNO=l.GNO AND s.lno=l.lno WHERE s.UNO ='$uno'" ;
	// echo "$query";
	// exit();
	$stid = _SQLOpen($GLOBALS['db'],$query);
	return $stid;
}
//ok
function _BEShareCancel($uno,$gno,$lno,$sno){
	$query = "DELETE TB_SHARE WHERE UNO='$uno'AND GNO='$gno'AND LNO='$lno'AND SNO ='$sno'" ;
	// echo "$query";
	// exit();
	$stid = _SQLExecu($GLOBALS['db'],$query);
	header("location:index.php?SETVIEW=beslist");
	exit();	
}

function _Shareselect($uno){
	$query = "SELECT * FROM TB_SHARE s LEFT JOIN TB_LIST l ON s.GNO=l.GNO AND s.lno=l.lno WHERE s.SNO ='$uno'" ;	
	// echo "$query";
	// exit();
	$stid = _SQLOpen($GLOBALS['db'],$query);
	return $stid;
}
function _ShareCancel($uno,$gno,$lno,$sno){
//echo "到這囉!!";
	$query = "DELETE TB_SHARE WHERE UNO='$uno'AND GNO='$gno'AND LNO='$lno'AND SNO ='$sno'" ;
	echo $query;
	$stid = _SQLExecu($GLOBALS['db'],$query);
	header("location:index.php?SETVIEW=slist");
	exit();	
}

//抓取時間
function  _Gettime(){
	date_default_timezone_set('Asia/Taipei');
	$time = date("Y/m/d-h:i:s");
	return $time;
}

function _bes_check($sno,$gno,$lno,$ino,$uno)
{
	$query = "UPDATE TB_ITEM SET oncheck = '$uno' WHERE UNO = '$sno' AND GNO = '$gno' AND LNO = '$lno' AND INO = '$ino' ";
// echo $query;
// exit();
	$stid = _SQLExecu($GLOBALS['db'],$query);
	header("location:index.php?SETVIEW=besitem");
	exit();

}
function _bes_Uncheck($sno,$gno,$lno,$ino)
{
	$query = "UPDATE TB_ITEM SET oncheck = '' WHERE UNO = '$sno' AND GNO = '$gno' AND LNO = '$lno' AND INO = '$ino' ";
// echo $query;
// exit();
	$stid = _SQLExecu($GLOBALS['db'],$query);
	header("location:index.php?SETVIEW=besitem");
	exit();
}
function _check($sno,$gno,$lno,$ino,$uno)
{
	$query = "UPDATE TB_ITEM SET oncheck = '$uno' WHERE UNO = '$sno' AND GNO = '$gno' AND LNO = '$lno' AND INO = '$ino' ";
// echo $query;
// exit();
	$stid = _SQLExecu($GLOBALS['db'],$query);
	header("location:index.php?SETVIEW=item");
	exit();

}
function _Uncheck($sno,$gno,$lno,$ino)
{
	$query = "UPDATE TB_ITEM SET oncheck = '' WHERE UNO = '$sno' AND GNO = '$gno' AND LNO = '$lno' AND INO = '$ino' ";
// echo $query;
// exit();
	$stid = _SQLExecu($GLOBALS['db'],$query);
	header("location:index.php?SETVIEW=item");
	exit();
}

function _BES_selectitem($sno,$gno,$lno,$uno){
	$query = "SELECT s.Sno,l.* FROM TB_SHARE s JOIN TB_item l ON s.GNO=l.GNO AND s.lno=l.lno WHERE s.UNO ='$uno' AND s.sno ='$sno' AND s.gno ='$gno' AND s.lno ='$lno'";	
	// echo $query;
	// exit();
	$stid = _SQLOpen($GLOBALS['db'],$query);   
	return $stid;
}



/*控制G-L-I的新增、修改、刪除*/
if ($set=="G_CREATE") {
	_GroupCreate($_GET['UNO'],$_GET['TITLE']);
}

elseif ($set=="G_EDIT") {
	_GroupEdit($_GET['UNO'],$_GET['GNO'],$_GET['EDIT_TITLE']);
}

elseif ($set=="G_DEL") {
	_GroupDelete($_GET['UNO'],$_GET['GNO']);
}

elseif ($set=="L_CREATE") {
	_ListCreate($_GET['UNO'],$_GET['GNO'],$_GET['TITLE']);
}

elseif ($set=="L_EDIT") {
	_ListEditTitle($_GET['UNO'],$_GET['GNO'],$_GET['LNO'],$_GET['EDIT_TITLE']);
}

elseif ($set=="L_SHARE") {
	_ListInsertShare($_GET['UNO'],$_GET['GNO'],$_GET['LNO'],$_GET['SNO']);
}

elseif ($set=="L_DEL") {
	_ListDelete($_GET['UNO'],$_GET['GNO'],$_GET['LNO']);
}

elseif ($set=="I_CREATE") {
	_ItemCreate($_GET['UNO'],$_GET['GNO'],$_GET['LNO'],$_GET['CONTENT'],$_GET['GNAME']);
}

elseif ($set=="I_EDIT") {
	_ItemEditContent($_GET['UNO'],$_GET['GNO'],$_GET['LNO'],$_GET['INO'],$_GET['EDIT_ITEM']);
}

elseif ($set=="I_DEL") {
	_ItemDelete($_GET['UNO'],$_GET['GNO'],$_GET['LNO'],$_GET['INO']);
}

elseif ($set=="BES_Cancel") {
	_BEShareCancel($_GET['UNO'],$_GET['GNO'],$_GET['LNO'],$_GET['SNO']);
}
elseif ($set=="S_Cancel") {
	_ShareCancel($_GET['UNO'],$_GET['GNO'],$_GET['LNO'],$_GET['SNO']);
}
elseif ($set=="I_CHK") {
	_check($_GET['SNO'],$_GET['GNO'],$_GET['LNO'],$_GET['INO'],$_GET['UNO']);
}	
elseif ($set=="I_UNCHK") {
	_Uncheck($_GET['SNO'],$_GET['GNO'],$_GET['LNO'],$_GET['INO']);
}
elseif ($set=="BES_I_CREATE") {
	_bes_ItemCreate($_GET['SNO'],$_GET['GNO'],$_GET['LNO'],$_GET['CONTENT'],$_GET['GNAME']);
}
elseif ($set=="BES_I_EDIT") {
	_bes_ItemEditContent($_GET['UNO'],$_GET['GNO'],$_GET['LNO'],$_GET['INO'],$_GET['EDIT_ITEM']);
}
elseif ($set=="BES_I_DEL") {
	_bes_ItemDelete($_GET['UNO'],$_GET['GNO'],$_GET['LNO'],$_GET['INO']);
}

elseif ($set=="BES_I_CHK") {
	_bes_check($_GET['SNO'],$_GET['GNO'],$_GET['LNO'],$_GET['INO'],$_GET['UNO']);
}	
elseif ($set=="BES_I_UNCHK") {
	_bes_Uncheck($_GET['SNO'],$_GET['GNO'],$_GET['LNO'],$_GET['INO']);
}





// function _ItemCreate($uno){}
// function _ItemEdit($uno){}
// function _ItemDelete($uno){}

