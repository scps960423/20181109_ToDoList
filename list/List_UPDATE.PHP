<!--使用GET方法之傳值到新New_Page(GITHUB下的)-->
<!DOCTYPE>
<html>
<head>
<title>DB_UPDATE</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<?php
/*連線*/
  $db = "oci:dbname=(description=(address=(protocol=tcp)(host=140.117.69.58)(port=1521))(connect_data=(sid=ORCL)));charset=utf8";
  $username = "Group17";
  $password = "group171717";

  try {
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'); 
    $dbh = new PDO($db, $username, $password);

    /*$_GET['XXX'] ， XXX = 另一個頁面要POST過來之數值*/
     $query="update TB_List set TITLE='".$_GET['NEW_LIST']."' 
      where GNO='".$_GET['GNO']."' and UNO='".$_GET['UNO']."' and LNO='".$_GET['LNO']."'  "; 
      echo "$query";
    $result = $dbh->prepare("$query");
    $result->execute();
    /*直接導回原頁面 */
    header("location:list.php");
  } catch (PDOException $e) {
  return("DB connect Error!: $e->getMessage()");
  die();
  }

?>

<body>
<table width="80%" border="0" align="left" cellpadding="0" cellspacing="1">
  <tr> 
    <td height="30" bgcolor="#CEFFCE"><font color="#006600" size="4"><strong>修改狀態</strong></font></td>
  </tr>

<!--創造欄位測試數值是否成功帶入此頁面-->

        <tr> 
          <td width="20%" height="25"><font size="2">T1</font></td>
          <td height="25"><input name="TELE" type="text" id="TELE" value="<?php echo $_GET["GNO"]; ?>"></td>
        </tr>
        <tr> 
          <td width="20%" height="25"><font size="2">T2</font></td>
          <td height="25"><input name="TELE" type="text" id="TELE" value="<?php echo $_GET["UNO"]; ?>"></td>
        </tr>
        <tr> 
          <td width="20%" height="25"><font size="2">T3</font></td>
          <td height="25"><input name="CLASS" type="text" id="CLASS" value="<?php echo $_GET["LNO"];?>"></td>
        </tr>
         <tr> 
          <td width="20%" height="25"><font size="2">T4</font></td>
          <td height="25"><input name="CLASS" type="text" id="CLASS" value="<?php  echo $_GET['NEW_LIST'];?>"></td>
        </tr>


  <tr> 
    <td height="25"><font size="2">
	<?php if($result)
			echo " 已經修改成功 ";
		else
			echo " 修改失敗 ";
	?></font></td>
  </tr>
  <tr> 
    <td height="25" align="center">
    <a href="list.php"><font size="4">回到清單</font></a> 
    </td>
  </tr>

  <br>
   
</table>

<tr>
    
</tr>

<div align="center"></div>
</body>
</html>
