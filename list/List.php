<?php
include_once "../Main.php"; 
/*防止跳出Notice*/
  error_reporting(0);


/*連線資料*/
    $db = "oci:dbname=(description=(address=(protocol=tcp)(host=140.117.69.58)(port=1521))(connect_data=(sid=ORCL)));charset=utf8";
    $username = "Group17";
    $password = "group171717";



	
	$uno = $_SESSION['UNO'];
  if (isset($_GET["GNO"]))
  {
    $_SESSION["GNO"]=$_GET["GNO"];
  }
  $List_GNO=$_SESSION['List_GNO'];

  if (isset($_GET["GNAME"]))
  {
    $_SESSION["GNAME"]=$_GET["GNAME"];
  }
  $GNAME=$_SESSION['GNAME'];


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

  <title>你好清單</title>
  <script>
    var json_baseDate = [{
      "name": "類別",
      "page":false
    },
    {
      "name": "清單",
      "page": true
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
        <div class="test">Hi!<span><?php echo $_SESSION['UNAME']; ?></span></div>
        <div class="tool"><a href="../index.php">返回類別</a></div>
      </div>
    </div>
    <div class="baseFrame" id="toDoList">
      <div class="baseMenu">
        <div class="list" >
          <ul v-for="(item,i) in list">
            <li><a href="#" v-on:click.prevent="tab(i)">{{ item.name }}</a></li>
          </ul>
        </div>
      </div>
      <div class="baseContent">
        <div class="page" v-if="list[1].page==true">
          <div class="title">【<?php echo $_SESSION['GNAME']; ?>】類別的{{list[1].name}}</div>
          <div class="content">

             <!--LIST新增開始-->            
            <form action="List_Insert.php" method="get">
               <!--UNO-->
               <input type="hidden" name="List_UNO" value="<?php echo $uno ;?>">
               <!--GNO-->
               <input type="hidden" name="List_GNO" value="<?php echo $_SESSION['GNO']?>">
               <FONT>新增清單之名稱</FONT>
               <input type="text" name="List_TITLE" value="">
               <input type="submit" value="新增">
            </form>
             <!--LIST更新結束-->  
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
        
                  <div class="name"><a href="../item/item.php?LNO=<?php echo $row["LNO"];?> &
                                                              GNO=<?php echo $_SESSION["GNO"]?> &
                                                              LTITLE=<?php echo $row["TITLE"]?>
                                                              ">
                  
                  <?php echo $row["TITLE"]; ?></a></div>
                  <div class="tool">

                    <!--LIST分享開始--> &nbsp;&nbsp;
                    <form action="List_SHARE.php" method="get">
                    <font>要分享之對象： </font>
                    <input type="text"   name="S_UNO" value="" >&nbsp;&nbsp; <!--要分享之對象-->
                    <input type="hidden" name="GNO" value="<?php  echo $row["GNO"];?>">
                    <input type="hidden" name="UNO" value="<?php  echo $_SESSION['UNO'];?>">
                    <input type="hidden" name="LNO" value="<?php  echo $row["LNO"];?>">
                    <a><input type="submit" value="分享"></a>
                    </form>
                    <!--LIST分享結束-->
                    &nbsp;&nbsp;
                    <!--LIST更新開始-->
                    <font>修改內容： </font>
                    <form action="List_UPDATE.php" method="get">
                    <input type="hidden" name="GNO" value="<?php  echo $row["GNO"];?>">
                    <input type="hidden" name="UNO" value="<?php  echo $_SESSION['UNO'];?>">
                    <input type="hidden" name="LNO" value="<?php  echo $row["LNO"];?>">
                    <input type="text"   name="NEW_LIST" value="" >&nbsp;&nbsp;
                    <a><input type="submit" value="修改"></a>
                    </form>
                    <!--LIST更新結束-->
                    &nbsp;&nbsp;
                    <!--LIST刪除開始-->
                    <a href="List_Delete.php?GNO=<?php  echo $row["GNO"];?>&
                                            UNO=<?php  echo $_SESSION['UNO'];?> &
                                            LNO=<?php  echo $row["LNO"];?>
                      "class="delete">刪除</a>
                    <!--LIST刪除結束-->
              
                        
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
        <div class="page" v-if="list[0].page==true"><a href="List_Insert.php"></a>
          <div class="title">【<?php echo $uname ?>】的{{list[0].name}}</a></div>

          <div class="content"></div>
        </div>
        <div class="page" v-if="list[2].page==true">
          <div class="title">【<?php echo $uname ?>】的{{list[2].name}}</div>
          <div class="content"></div>
        </div>



      </div>
    </div>

  </div>
  <script src="../js/main.js"></script>
</body>

</html>