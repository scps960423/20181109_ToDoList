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
    $query="INSERT INTO tb_group (UNO, TITLE) VALUES ('".$_GET['Insert_UNO']."', '".$_GET['Insert_TITLE']."')"; 

    $result = $dbh->prepare("$query");
    $result = $dbh->prepare("$query");
    $result->execute();
    header("location:index.php");
  } catch (PDOException $e) {
  return("DB connect Error!: $e->getMessage()");
  die();
  }

?>

<body>
<table width="80%" border="0" align="left" cellpadding="0" cellspacing="1">
  <tr> 
    <td height="30" bgcolor="#CEFFCE"><font color="#006600" size="4"><strong>新增狀態</strong></font></td>
  </tr>

<!--創造欄位測試數值是否成功帶入此頁面-->

        <tr> 
          <td width="20%" height="25"><font size="2">T1</font></td>
          <td height="25"><input name="TELE" type="text" id="TELE" value="<?php echo $_GET["Insert_UNO"]; ?>"></td>
        </tr>
        <tr> 
          <td width="20%" height="25"><font size="2">T2</font></td>
          <td height="25"><input name="CLASS" type="text" id="CLASS" value="<?php echo $_GET["Insert_TITLE"];?>"></td>
        </tr>




  <tr> 
    <td height="25"><font size="2">
  <?php if($result)
      echo "新增取值成功";
    else
      echo " 新增取值失敗 ";
  ?></font></td>
  </tr>
  <tr> 
    <td height="25" align="center">
    <a href="index.php"><font size="4">回到清單</font></a> 
    </td>
  </tr>
  <br>
   
</table>

<tr>
    
</tr>

<div align="center"></div>
</body>
</html>
