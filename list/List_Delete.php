<!DOCTYPE>
<html>
<head>
<title>DB_Project1_Test</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<?php
  
  
  $db = "oci:dbname=(description=(address=(protocol=tcp)(host=140.117.69.58)(port=1521))(connect_data=(sid=ORCL)));charset=utf8";
  $username = "Group17";
  $password = "group171717";

  try {
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'); 
    $dbh = new PDO($db, $username, $password);
    $query="delete FROM TB_list where GNO='".$_GET["GNO"]."' AND UNO='".trim($_GET["UNO"])."' AND LNO='".$_GET["LNO"]."'";
    echo "$query";
    $result = $dbh->prepare("$query");
    $result->execute();
    header("location:http://localhost/Git_Project/20181109_ToDoList/list/list.php");
  } catch (PDOException $e) {
  return("DB connect Error!: $e->getMessage()");
  die();
  }

?>

<body>
<table width="80%" border="0" align="left" cellpadding="0" cellspacing="1">
  <tr> 
    <td height="30" bgcolor="#CEFFCE"><font color="#006600" size="4"><strong>刪除狀態</strong></font></td>
  </tr>

  <tr> 
    <td height="25"><font size="2">
	<?php if($result)
		  echo "刪除成功";
		else
			echo " 刪除失敗 ";
	?></font></td>
  </tr>

<!--創造欄位測試數值是否成功帶入此頁面-->

        <tr> 
          <td width="20%" height="25"><font size="2">要刪除的GROUP之GNO</font></td>
          <td height="25"><input name="TELE" type="text" id="TELE" value="<?php echo $_GET["GNO"]; ?>"></td>
        </tr>
         <tr> 
          <td width="20%" height="25"><font size="2">要刪除的GROUP之UNO</font></td>
          <td height="25"><input name="TELE" type="text" id="TELE" value="<?php echo $_GET["UNO"]; ?>"></td>
        </tr>
         <tr> 
          <td width="20%" height="25"><font size="2">要刪除的GROUP之LNO</font></td>
          <td height="25"><input name="TELE" type="text" id="TELE" value="<?php echo $_GET["LNO"]; ?>"></td>
        </tr>



  <tr> 
    <td height="25" align="center">
    <a href="list.php"><font size="4">回到清單</font></a> 
    </td>
  </tr>

  <tr> 
    <td height="25" align="right"  bgcolor="#CEFFCE">
    <a href="List.php"><font size="4">查詢</font></a> 
    </td>
  </tr>
  <br>
   
</table>

<tr>
    
</tr>

<div align="center"></div>
</body>
</html>
