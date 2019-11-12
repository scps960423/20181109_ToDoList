

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

  /*連線資料*/
  $db = "oci:dbname=(description=(address=(protocol=tcp)(host=140.117.69.58)(port=1521))(connect_data=(sid=ORCL)));charset=utf8";
  $username = "Group17";
  $password = "group171717";

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
        Hi To Do
      </div>
      <div class="moduleUser">

        
        <div class="test">Hi!<span><?php echo $_SESSION['UNAME']; ?> </span></div>
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
          <div class="title">【<?php echo $uname ?>】的{{list[0].name}}</div>
          <div class="content">

    		<!--新增開始-->
            <form action="DB_Insert.php" method="get">
            <!--先給Uno固定給Session傳入的值，傳入DB_Insert做為值來新增欄位-->
            <font>新的類別:</font>

            <input type="Hidden" name="Insert_UNO" value="<?php echo $uno ;?>">
            <input type="text"   name="Insert_TITLE">
            <input type="submit" value="新增" >
            </from>
			<!--新增結束-->

           
<!--新增結束-->

            <div class="list">
              <ul>
                <?php
                try {
                  $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
                  $dbh = new PDO($db, $username, $password);

                  $query = "SELECT * FROM TB_GROUP WHERE UNO = '$uno'";
                  $result = $dbh->prepare("$query");
                  $result->execute();
                  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    ?>

                    <li>
                    	 <div class="name"><a href="List/List.php?GNO=<?php  echo $row["GNO"];?> &
                                                           UNO=<?php  echo $_SESSION['UNO'];?>&
                                                           GNAME= <?php echo $row["TITLE"]; ?> ">
                  		 <!--顯示-->
                  		 <?php echo $row["TITLE"]; ?>                                           
                  		 </a></div>

                     <div class="tool">
                        <!--類別更新開始-->
                        <font>修改內容：</font>
                   		<form action="DB_UPDATE.php" method="get">
                    	<input type="hidden" name="GNO" value="<?php  echo $row["GNO"];?>">
                    	<input type="hidden" name="UNO" value="<?php  echo $uno;?>">
                    	<input type="text"   name="NEW_TITLE">&nbsp;&nbsp;
                    	<input type="submit" value="修改">
                    	</form>
                        <!--類別更新結束-->
                        &nbsp;&nbsp;
                    	<!--LIST刪除開始-->
                   		<a href="DB_Delete.php?GNO=<?php  echo $row["GNO"];?>&
                                                 UNO=<?php  echo $_SESSION['UNO'];?>"
                        class="delete">刪除</a>
                        <!--LIST刪除結束-->
                     </div>

                    </li>
                <?php /*wHILE 下半段*/
                  }
                } catch (PDOException $e) {
                  return ("DB connect Error!: $e->getMessage()");
                  die();
                }
                ?>
              </ul>
            </div>
          </div>
        </div>

        <!--清單-->
        <div class="page" v-if="list[1].page==true"></a>
          <div class="title">【<?php echo $uname ?>】的{{list[1].name}}</div>
          <div class="content">
            <div class="tool"><a href="#">add+</a></div>
            <div class="list">
              <ul>
                  <?php
                   /*顯示 While 上半段*/
                   try {
                        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
                        $dbh = new PDO($db, $username, $password);
                        $query = "SELECT * FROM TB_LIST WHERE UNO = '".$uno."' AND GNO = '".$_SESSION['GNO']."' ";
                        //顯示SQL
                        //echo "$query";
                        $result = $dbh->query("$query");

                  foreach ($result as $row ) {
                    ?>
                <li>
                    <div class="name"><a href="http://"><?php echo $row["TITLE"]; ?></a></div>
                    <div class="tool">
                    <a href="http://" class="edit">編輯</a>
                    <a href="http://" class="delete">刪除</a>
                    </div>
                </li>
                <!--顯示 While下半段-->
                <?php
                      }
                        } catch (PDOException $e) {
                          return ("DB connect Error!: $e->getMessage()");
                          die();
                        }
                ?>
              </ul>
            </div>
          </div>
        </div>


        <!--被分享清單-->
        <div class="page" v-if="list[2].page==true">
          <div class="title">【<?php echo $uname ?>】的{{list[2].name}}</div>
           <div class="content">
            <!--Q在這個清單上做一個跳轉到/list/list.php上-->
            <div class="list">
              <ul>
              	<!--被分享清單select及顯示-->
             	<?php
                 /*顯示 While 上半段*/
                try {
                  $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
                  $dbh = new PDO($db, $username, $password);

                  $query2 = "SELECT * FROM TB_SHARE JOIN TB_LIST ON(TB_SHARE.GNO = TB_LIST.GNO) WHERE SNO = '$uno'"  ;
                  //顯示SQL
                  //echo "$query2";
                  $result = $dbh->query("$query2");

                  foreach ($result as $row ) {
                    ?>
                <li>
                   <div class="name"><a href="index.php"><?php echo $row["TITLE"]; ?>
                   	＜擁有者：<?php echo $row["UNO"]; ?>＞</a></div>
                   	<!--
                   	<div class="tool">
                       <a href="Db_Share_Del.php?SNO=<?php echo $uno ;?>&
                       							 GNO=<?php echo $row["GNO"]; ?> &
                       							 LNO=<?php echo $row["LNO"]; ?> &
                       							 UNO=<?php echo $row["UNO"]; ?>

                       	" Class = "delete">
                       刪除</a>
                    </div>-->
                </li>
                <!--顯示 While下半段-->
                <?php
                      }
                        } catch (PDOException $e) {
                          return ("DB connect Error!: $e->getMessage()");
                          die();
                        }
                ?>
              </ul>
            </div>
          </div> 
          
      </div>
    </div>

  </div>
  <script src="./js/main.js"></script>
</body>


</html>