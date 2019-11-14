<?php  
/*防止跳出Notice*/
  error_reporting(0);
/*這是 item */
include_once "../Main.php";

/*將item 所需變數 存在session */ 
//item 需 UNO GNO LNO AUTHOR(UNAME)
$AUTHOR=$_SESSION['UNAME'];
//$GNO=sesisset($_GET["GNO"],$_SESSION["GNO"]);
if (isset($_GET["GNO"]))
  {
    $_SESSION["GNO"]=$_GET["GNO"];
  }
  $GNO=$_SESSION['GNO'];
//$LNO=sesisset($_GET["LNO"],$_SESSION["LNO"]);

//Sesisset去判斷此值是否為空是否要存
$LTITLE=sesisset($_GET["LTITLE"],$_SESSION["LTITLE"]);

$UNO=$_SESSION['UNO'];

if (isset($_GET["LNO"]))
  {
    $_SESSION["LNO"]=$_GET["LNO"];
  }
  $LNO=$_SESSION['LNO'];
//$LNO=sesisset($_GET["LNO"],$_SESSION["LNO"]);

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
      "name": "事項",
      "page":true
    },
    {
      "name": "我分享的清單",
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
        <div class="test">Hi!<span><?php echo $_SESSION['UNAME']; ?></span></div>
        <div class="tool"><a href="../list/list.php">返回清單</a></div>
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
        <div class="page" v-if="list[0].page==true">
          <div class="title">【<?PHP echo $LTITLE ?>】LIST的{{list[0].name}}</div>
          <div class="content">
            
            <div class="list">
              <ul>
                <!--Item.create-->
                <form action="../main.php" method="get">
                    <input type="hidden" name="UNO" value="<?php echo($UNO)?>">
                    <input type="hidden" name="LNO" value="<?php echo($LNO)?>">
                    <input type="hidden" name="GNO" value="<?php echo($GNO)?>">
                    <FONT>清單內容</FONT>
                    <input type="text" name="CONTENT" placeholder="輸入內容">
                    <input type="hidden" name="AUTHOR" value="<?php echo($AUTHOR)?>">
                    <input type="hidden" name="set" value="1">
                    <input type="submit" value="新增">
                </form>
                <?php
                   /*顯示 While 上半段*/
                   try {
                        $conn = _dbconnect();
                        $query = "SELECT * FROM TB_ITEM WHERE UNO='".$UNO."' AND GNO='".$GNO."'
                        AND LNO='".$LNO."' ";
                        //顯示SQL
                        //echo "$query";
                        $result = $conn->query($query);
                        foreach ($result as $row ) {
                    ?>
                <!--ITEM display-->
                <li>
                  <div class="name"><a href="http://"><?php echo $row["CONTENT"];?></a></div>

                  <div class="tool">
                <!--ITEMEdit-->
                <form action="../main.php" method="get">
                    <input type="hidden" name="UNO" value="<?php echo($UNO)?>">
                    <input type="hidden" name="GNO" value="<?php echo($GNO)?>">
                    <input type="hidden" name="LNO" value="<?php echo($LNO)?>">
                    <input type="hidden" name="INO" value="<?php echo $row["INO"];?>">
                    <input type="text" name="EDIT" placeholder="修改內容">
                    <input type="hidden" name="set" value="2">
                    <input type="submit" value="修改"> &nbsp;&nbsp;
                </form>
                    <!--a href="http://" class="edit">編輯</a-->

                <!--ITEM Del-->
                    <a href="../Main.php? UNO=<?php  echo $UNO?>&
                                          GNO=<?php  echo $GNO?>&
                                          LNO=<?php  echo $LNO?>&
                                          INO=<?php  echo $row["INO"]?>&
                                          set=3
                      "class="delete">刪除</a>
                  </div>
                </li>
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
        <div class="page" v-if="list[1].page==true">
          <div class="title">{{list[1].name}}</div>
          <div class="content"></div>
        </div>
        <div class="page" v-if="list[2].page==true">
          <div class="title">{{list[2].name}}</div>
          <div class="content"></div>
        </div>
      </div>
    </div>

  </div>
  <script src="../js/main.js"></script>
</body>

</html>