<?php
  include("Main.php");
   

  
  /*取session的NUO &UNAME數值 */
  if (isset($_POST['submit_g_create'])) {
    _GroupCreate($_SESSION['UNO'],$_POST['gtitle']);
  }

  if (!isset($_SESSION['UNO'])) {
    header("Location:signIn.php");
 }

  $uno =$_SESSION['UNO']; //uno
  $uname = $_SESSION['UNAME']; //uname
  $query = "SELECT u.*,g.title AS gtitle,l.title AS ltitle,l.createday AS lcreate,i.content,i.author,i.createday AS icreate,i.oncheck";
  $query .= " FROM TB_USER u LEFT JOIN tb_group g ON u.uno=g.uno LEFT JOIN tb_list l ON g.uno=l.uno AND g.gno=l.gno LEFT ";
  $query .= "JOIN tb_item i ON l.uno=i.uno AND l.gno=i.gno AND l.lno=i.lno WHERE u.UNO = '$uno'";
  $stid = _SQLOpen($GLOBALS['db'],$query);
  $resultJSON_own = json_encode($stid->fetchAll(PDO::FETCH_ASSOC)); //user自己的Group..到item的Json
  // $json_string = json_encode($resultJSON_own, JSON_PRETTY_PRINT);
  // echo $json_string;
  // print_r($resultJSON_own);

  $query = "SELECT s.*,l.title AS ltitle,l.createday AS lcreate,i.content,i.author,i.createday AS icreate,i.oncheck ";
  $query .= "FROM TB_USER u ";
  $query .= "LEFT JOIN tb_share s ON u.uno=s.sno ";
  $query .= "LEFT JOIN tb_list l ON s.sno=l.uno AND s.gno=l.gno ";
  $query .= "LEFT JOIN tb_item i ON l.uno=i.uno AND l.gno=i.gno AND l.lno=i.lno WHERE u.UNO = '$uno'";
  $stid = _SQLOpen($GLOBALS["db"],$query);
  $resultJSON_Share = json_encode($stid->fetchAll(PDO::FETCH_ASSOC));//user分享的list的Json

  $query = "SELECT s.*,l.title AS ltitle,l.createday AS lcreate,i.content,i.author,i.createday AS icreate,i.oncheck ";
  $query .= "FROM TB_USER u ";
  $query .= "LEFT JOIN tb_share s ON u.uno=s.uno ";
  $query .= "LEFT JOIN tb_list l ON s.sno=l.uno AND s.gno=l.gno ";
  $query .= "LEFT JOIN tb_item i ON l.uno=i.uno AND l.gno=i.gno AND l.lno=i.lno WHERE u.UNO = '$uno'";
  $stid = _SQLOpen($GLOBALS['db'],$query);
  $resultJSON_BeShare = json_encode($stid->fetchAll(PDO::FETCH_ASSOC));//user被分享的list的Json

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="/css/style.css">
  <link rel="stylesheet" href="/css/rect.css">
  <script src="http://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <title>HiToDo</title>
  <script>
    var $groupTool = $('.baseContent .content .tool'),
      $addBut = $groupTool.find('.addBut a'),
      $input = $groupTool.find('.input');

    $addBut.click(function(e) {
      e.preventDefault();
      console.log($(this)[0]);
      $input.toggleClass('is-active');
    });
    var json_baseDate = [{
        "name": "類別",
        "page": true
      },
      {
        "name": "清單",
        "page": false
      },
      {
        "name": "共享的清單",
        "page": false
      }
    ];
  </script>
</head>

<body>
  <div class="layout">
    <div class="baseHeader">
      <div class="logo">
        to do List
      </div>
      <div class="moduleUser">

        
        <div class="test">hi!<span><?php echo $_SESSION['UNAME']; ?> </span></div>
        <div class="tool"><a href="signIn.php">Sign out</a></div>

      </div>
    </div>
    <div class="baseFrame" id="toDoList">
      <div class="baseMenu">
        <div class="list">
          <ul v-for="(item,i) in list">
            <li><a href="#" v-on:click.prevent="tab(i)">{{ item.name }}</a></li>
          </ul>
        </div>
      </div>
      <div class="baseContent">
        <div class="page" v-if="list[0].page==true">
          <div class="title">{{list[0].name}}</div>
<!--新增開始-->
          <div class="content">
            <form action="DB_Insert.php" method="get">
            <div class="tool">
            <!--先給Uno固定給Session傳入的值，傳入DB_Insert做為值來新增欄位-->
            <input type="Hidden" name="Insert_UNO" value="<?php echo $_SESSION['UNO'];?>">
            <font>新的類別:</font>
            <input type="text" name="Insert_TITLE">
            <input type="hidden" name="group" value="Group_Insert">
            <!--Q CSS套不到下面的Input上-->
            <input type="submit" value="新增" >
            </div>
            </from>
<!--新增結束-->
            <div class="list">
              <ul>
                <?php

                $db = "oci:dbname=(description=(address=(protocol=tcp)(host=140.117.69.58)(port=1521))(connect_data=(sid=ORCL)));charset=utf8";
                $username = "Group17";
                $password = "group171717";

                try {
                  $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
                  $dbh = new PDO($db, $username, $password);

                  $query = "SELECT * FROM TB_GROUP WHERE UNO = '$uno'";
                  $result = $dbh->prepare("$query");
                  $result->execute();
                  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <li>
                         <!--傳值到LIST開始-->
                        <div class="name"><a href="List/List.php?GNO=<?php  echo $row["GNO"];?> &
                        										 UNO=<?php  echo $_SESSION['UNO'];?> ">
                        <?php echo $row["TITLE"]; ?>										
                        </a>
                        </div>
                        <!--傳值到LIST結束-->
                        <div class="tool">
                        <!--編輯Start-->
                        <form action="DB_UPDATE.php" method="get">
                        <!--Hidden 要傳送的GNO & UNO-->
                        <input type="Hidden" name="GNO" value="<?php  echo $row["GNO"];?>"> 
                        <input type="Hidden" name="UNO" value="<?php  echo $row["UNO"];?>"> 
                        <!--Q3：讓修改在點編輯的狀況下才出現輸入文字框-->
                        <input type="text" name="NEW_TITLE">
                        <!--提交按鈕型態為submit「傳送資料」-->
                        <!--Q1：套用不上CSS-->
                       <div class="edit">
                    <input type="submit" value="修改">
                    </div>
                  </form>
                  <!--編輯結束-->
                        <a href="DB_Delete.php?GNO=<?php  echo $row["GNO"];?>"class="delete">刪除</a>
                      </div>
                    </li>
                <?php
                  }
                } catch (PDOException $e) {
                  return ("DB connect Error!: $e->getMessage()");
                  die();
                }

                ?>
                <li>
                  <div class="name"><a href="http://">HOME</a></div>
                  <div class="tool">
                    <a href="http://" class="edit">編輯</a>
                    <a href="http://" class="delete">刪除</a>  
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>

         <div class="page" v-if="list[1].page==true">
          <div class="title">{{list[1].name}}</div>
          <div class="content"></div>
        </div>
        <div class="page" v-if="list[2].page==true">
          <div class="title">{{list[2].name}}</div>
          <div class="content">
          	

          </div>
        </div>
      </div>
    </div>

  </div>
  <script src="./js/main.js"></script>
</body>


</html>