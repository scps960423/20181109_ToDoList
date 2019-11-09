<?php
function dbconnect(){
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

function SQLOpen($dbcon,$query)
{
	try {
		$result = $dbcon->query($query);
	} catch (PDOException $e){
		$result = $e->getMessage();
	}
	return $result;
}

function SQLExecu($dbcon,$query)
{
	try {
		$result = $dbcon->exec($query);
	} catch (PDOException $e){
		$result = $e->getMessage();
	}	
	echo $result;
}
#example
// $query = "INSERT INTO TB_USER VALUES('a','a','a','a')";
// $stid = SQLExecu($conn,$query);

// $query = "SELECT * FROM TB_USER";
// $stid = SQLOpen($conn,$query);
// foreach($stid as $row){
//     echo $row['UNO']."<br>";
//     echo $row['PWD']."<br>";
//     echo $row['UNAME']."<br>";
//     echo $row['EMAIL']."<br>";
// }