<?php
	include_once "../Main.php"; 
	$uno = $_SESSION['UNO']
?>
<?php
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

  <title>你好清單</title>
  <script>
    var json_baseDate = [{
      "name": "清單",
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
        <div class="test">hi!<span>王小明</span></div>
        <div class="tool"><a href="#">Sign out</a></div>
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
          <div class="title">{{list[0].name}}</div>
          <div class="content">

            <!--測試數值是否有傳到LIST-->
            <form action="List_Insert.php" method="get">
             <FONT>UNO</FONT>
               <input type="text" name="List_UNO" value="<?php echo $uno ?>">
             <FONT>GNO</FONT>
               <input type="text" name="List_GNO" value="<?php echo $_GET["GNO"]; ?>">
             <FONT>TITLE</FONT>
               <input type="text" name="List_TITLE" >
             <input type="submit" value="新增">
            </form>
            <div class="tool"><a href="#">add+</a></div>
            <div class="list">
              <ul>
                 <?php
                 /*While 上半段*/
                try {
                  $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
                  $dbh = new PDO($db, $username, $password);

                  $query = "SELECT * FROM TB_LIST WHERE UNO = '".$_GET['UNO']."' AND GNO = '".$_GET['GNO']."' ";
                  echo "$query";
                  $result = $dbh->prepare("$query");
                  $result->execute();
                  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                <li>
                  <div class="name"><a href="http://"><?php echo $row["TITLE"]; ?></a></div>
                  <div class="tool">
                    <a href="http://" class="edit">編輯</a>
                    <a href="http://" class="delete">刪除</a>
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
          <div class="content"></div>
        </div>



      </div>
    </div>

  </div>
  <script src="./js/main.js"></script>
</body>

</html>