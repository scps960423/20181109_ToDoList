<?php 
  include_once "Main.php"; 
  if (!isset($_SESSION)) {
    session_start();
  }
  global $db;
  $db = _dbconnect();
  if($_POST['submit'])
  {
    _Login($_POST['account'],$_POST['password']);
  }
  function _Login($uno,$pwd)
  {
    try { 
      $query = "SELECT * FROM TB_USER WHERE UNO = '$uno' AND PWD = '$pwd'";
      $stid = _SQLOpen($GLOBALS['db'],$query);
      $result = $stid->fetchAll();
      if(count($result) > 0){
        $_SESSION['UNO'] = $_POST['account'];
            header("Location:index.php");
      }else{
        echo " 登入失敗 ";
      }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="/css/style.css">
  <link rel="stylesheet" href="/css/rect.css">
  <title>Document</title>
</head>
<body>
  <div class="signInLayout">
    <div class="img"></div>
    <div class="signInContent">
      <div class="logo"><img src="./images/Logo_mainpng" alt=""></div>
      <div class="conter">  
        <form name="form" method="post" action="">
        <div class="input">
          <div class="item">          
            <label for="account">帳號</label>
            <input id="account" type="text" name="account">
          </div>
          <div class="item">
            <label for="password">密碼</label>
            <input id="password" type="text" name="password">
          </div>
        </div>
          <div class="tool">
          <input type="submit" value="登入" name="submit">
          <div class="p">沒有帳號<span><a href="#">點我註冊</a></span></div>
        </div>
      </form>
      </div>      
    </div>
  </div>
</body>
</html>
