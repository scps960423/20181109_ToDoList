<!DOCTYPE>
<html>
<head>
<title>List_Share</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<?php

  $db = "oci:dbname=(description=(address=(protocol=tcp)(host=140.117.69.58)(port=1521))(connect_data=(sid=ORCL)));charset=utf8";
  $username = "Group17";
  $password = "group171717";


  try {
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'); 
    $dbh = new PDO($db, $username, $password);
    
    $query="INSERT INTO TB_SHARE (SNO , GNO , UNO ,LNO) VALUES ('".$_GET['S_UNO']."', '".$_GET['GNO']."'
    , '".$_GET['UNO']."', '".$_GET['LNO']."')"; 
    //echo "$query";
    $result = $dbh->prepare("$query");
    $result = $dbh->prepare("$query");
    $result->execute();
    //header("location:http://localhost/Git_Project/20181109_ToDoList/index.php");
  } catch (PDOException $e) {
  return("DB connect Error!: $e->getMessage()");
  die();
  }

?>

<body>
<table width="80%" border="0" align="left" cellpadding="0" cellspacing="1">
  <tr> 
    <td height="30" align="center" bgcolor="#D2E9FF"><font color="#006600" size="4"><strong>分享狀態</strong></font></td>
  </tr>

<!--創造欄位測試數值是否成功帶入此頁面-->

        <tr> 
          <!--td width="20%" height="25"><font size="2">S_UNO</font></td>-->
          <td height="25"><input name="TELE" type="hidden" id="TELE" value="<?php echo $_GET["S_UNO"]; ?>"></td>
        </tr>
        <tr> 
          <!--<td width="20%" height="25"><font size="2">GNO</font></td>-->
          <td height="25"><input name="CLASS" type="hidden" id="CLASS" value="<?php echo $_GET["GNO"];?>"></td>
        </tr>
        <tr> 
          <!--<td width="20%" height="25"><font size="2">UNO</font></td>-->
          <td height="25"><input name="CLASS" type="hidden" id="CLASS" value="<?php echo $_GET["UNO"];?>"></td>
        </tr>
        <tr> 
          <!--<td width="20%" height="25"><font size="2">LNO</font></td>-->
          <td height="25"><input name="CLASS" type="hidden" id="CLASS" value="<?php echo $_GET["LNO"];?>"></td>
        </tr>




  <tr> 
    <td height="25" align="center"><font size="5">
  <?php if($result)
      echo "【分享成功】";
    else
      echo " 分享失敗 ";
  ?></font></td>
  </tr>
  <tr> 
    <td height="25" align="center">
    <a href="../index.php"><font size="4">返回主類別</font></a> 
    </td>
  </tr>
  <br>
   
</table>

<tr>
    
</tr>

<div align="center"></div>
</body>
</html>
