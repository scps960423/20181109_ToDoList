<?php 
  include("Main.php");
  if (!isset($_SESSION)) {
    session_start();
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
         <?php 
              if(isset($_POST['submit_Signup']))//1
              {
                  echo '<label for="account">SignUp</label>';
              }
              else
              {
                  echo '<label for="account">Login</label>';
              }

          ?>
        <form name="form" method="post" action="Main.php">
        <div class="input">
          <div class="item">          
            <label for="account">帳號</label>
            <input id="account" type="text" name="account">
          </div>
          <div class="item">
            <label for="password">密碼</label>
            <input id="password" type="text" name="password">
          </div>
         <?php 
             if(isset($_POST['submit_Signup']))//1
              {
               
                echo '<div class="item"> ';         
                echo '  <label for="uname">姓名</label>';
                echo '  <input id="uname" type="text" name="uname">';
                echo '</div>';
                echo '<div class="item">';
                echo '  <label for="email">E-MAIL</label>';
                echo '  <input id="email" type="text" name="email">';
                echo '</div>';
                echo '<form name="form" method="post" action="">';
                echo '<input type="submit" value="確認註冊" name="submit_Signup1">';//2
                echo '<input type="submit" value="取消" name="submit_Signup2">';
                echo '</form>';
                echo '</form>';
              }
              else
              {
                echo '<input type="submit" value="登入" name="submit_Login">';//1
                echo '</form>';
                echo '<form name="form" method="post" action="">';
                echo '<input type="submit" value="開始註冊" name="submit_Signup">';
                echo '</form>';
              }
         ?>
        </div>         
        <?php         
        // var_dump($_POST) ;
          if(isset($_POST['submit_Signup1']))//2
          {
            echo "has into";
            _AccountCreate($_POST['account'],$_POST['password'],$_POST['uname'],$_POST['email']);            
          }
          if(isset($_POST['submit_Signup2'])){
            header('Location:signIn.php');
          }
        ?> 
        <!-- </div>   -->
      </div>      
    </div>
  </div>
</body>
</html>
