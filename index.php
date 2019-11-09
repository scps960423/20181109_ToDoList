<?php

/*連線資料，點下新增時*/
 if($_POST['submit'])
 {
  //db host&port&sid + user & password
  $db = "oci:dbname=(description=(address=(protocol=tcp)(host=140.117.69.58)(port=1521))(connect_data=(sid=ORCL)));charset=utf8";
  $username = "Group17";
  $password = "group171717";
try {
  $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'); 
    $dbh = new PDO($db, $username, $password);
    //下達INSERT INTO 的語法 
    $query="INSERT INTO tb_group (TITLE) VALUES ('".$_POST['TITLE']."')"; 
      $result = $dbh->prepare("$query");
      $result->execute();
      //header("location:http://localhost/Project1/list.php");
    }
catch (PDOException $e) {
    return("DB connect Error!: $e->getMessage()");
    die();
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <title>你好清單</title>
  <script>
    var $groupTool = $('.baseContent .content .tool'),
        $addBut = $groupTool.find('.addBut a'),
        $input = $groupTool.find('.input');
        
        $addBut.click(function(e){
            e.preventDefault();
            console.log($(this)[0]);
            $input.toggleClass('is-active');
        });
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
    <div class="baseFrame">
      <div class="baseMenu">
        <div class="list">
          <ul>
            <li><a href="#">類別</a></li>
            <li><a href="#">我分享的清單</a></li>
            <li><a href="#">共享的清單</a></li>
          </ul>
        </div>
      </div>
      <div class="baseContent">
        <div class="title">類別</div>
        <div class="content">
          <div class="tool">
            <div class="input"><input name="TITLE" type="text" id="TITLE"></div>
            <div class="addBut"><a href="#"><input name="submit" type="submit" id="submit" value="新增"></a></div>
          </div>

          <div class="list">
            <ul>
<?php

  $db = "oci:dbname=(description=(address=(protocol=tcp)(host=140.117.69.58)(port=1521))(connect_data=(sid=ORCL)));charset=utf8";
  $username = "Group17";
  $password = "group171717";

try {
  $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'); 
  $dbh = new PDO($db, $username, $password);

  $query = "SELECT * FROM TB_GROUP";
  $result = $dbh->prepare("$query");
  $result->execute();
  while ($row = $result->fetch(PDO::FETCH_ASSOC))  {
    ?>
              <li>
                <div class="name"><?php echo $row["TITLE"];?></div>
                <div class="tool">
                  <a href="http://" class="edit">編輯</a>
                  <a href="http://" class="delete">刪除</a>
                </div>
              </li>
<?php
  }
 
} catch (PDOException $e) {
  return("DB connect Error!: $e->getMessage()");
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
    </div>

  </div>
</body>


</html>

   
   
    