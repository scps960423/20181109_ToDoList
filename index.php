
<?php
  /*防止跳出Notice*/
  error_reporting(0);

  include("Main.php");

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


//isset

$_SESSION['GNAME']="請先選擇類別";
$_SESSION["LNAME"]="請先選擇清單";


 
 //判斷值是否被set - GNO
 if (isset($_GET["GNO"]))
  {
    $_SESSION["GNO"]=$_GET["GNO"];
  }
  $gno=$_SESSION['GNO'];

//判斷值是否被set - LNO
   if (isset($_GET["LNO"]))
  {
    $_SESSION["LNO"]=$_GET["LNO"];
  }
  $lno=$_SESSION['LNO'];

//判斷值是否被set - GNAME
  if (isset($_GET["GNAME"]))
  {
    $_SESSION["GNAME"]=$_GET["GNAME"];
  }
  $gname=$_SESSION['GNAME'];
////判斷值是否被set - LNAME
    if (isset($_GET["LNAME"]))
  {
    $_SESSION["LNAME"]=$_GET["LNAME"];
  }
  $lname=$_SESSION['LNAME'];

  //利用Main_Header回傳值當變數傳到Script中決定要開啟那個畫面。
  $Setview = $_GET["SETVIEW"];

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
  	//初始狀態
  	var json_baseDate = [{"name": "類別","page": true},{"name": "清單","page": false},{"name": "項目","page": false}, 
    	{"name": "被分享清單","page": false},{"name": "分享清單","page": false} ];
  	
  	//--------------待整合成function--------------------------------------------------------------------------------------
  	var Setview="<?php echo $Setview; ?>";
  	if(Setview=='group'){
  		var json_baseDate = [{"name": "類別","page": true},{"name": "清單","page": false},{"name": "項目","page": false}, 
    	{"name": "被分享清單","page": false},{"name": "分享清單","page": false} ];
  	}
  	else if(Setview=='list'){//清單頁面動作後回傳狀態
  		var json_baseDate = [{"name": "類別","page": false},{"name": "清單","page": true},{"name": "項目","page": false}, 
    	{"name": "被分享清單","page": false},{"name": "分享清單","page": false} ];
  	}
  	else if(Setview=='item'){//項目頁面動作後回傳狀態
  		var json_baseDate = [{"name": "類別","page": false},{"name": "清單","page": false},{"name": "項目","page": true}, 
    	{"name": "被分享清單","page": false},{"name": "分享清單","page": false} ];
  	}
  	else if(Setview=='beslist'){//被分享清單頁面動作後回傳狀態
  		var json_baseDate = [{"name": "類別","page": false},{"name": "清單","page": false},{"name": "項目","page": false}, 
    	{"name": "被分享清單","page": true},{"name": "分享清單","page": false} ];
  	}
  	else if(Setview=='slist'){//分享清單頁面動作後回傳狀態
  		var json_baseDate = [{"name": "類別","page": false},{"name": "清單","page": false},{"name": "項目","page": false}, 
    	{"name": "被分享清單","page": false},{"name": "分享清單","page": true} ];
  	}
  	
    

  </script>

</head>

<body>
  <div class="layout">
    <div class="baseHeader">
      <div class="logo">
        to do List
      </div>
      <div class="moduleUser">
        <div class="test">Hi!<span><?php echo $uname ?></span></div>
        <div class="tool"><a href="signIn.php">Sign out</a></div>
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
      	<!--類別-->
        <div class="page" v-if="list[0].page==true">
          <div class="title">【<?php echo $uname ?>】的{{list[0].name}}</div>
          <div class="content">
            <div class="tool">
            	<!--G_CREATE-->
            	<form action="Main.php" method="get">
            		<input type="hidden" name="UNO" value="<?php echo($uno)?>">
            		<input type="hidden" name="set" value="G_CREATE">
            		<input type="text" name="TITLE" placeholder="新增類別名稱">
            	 	<input type="submit" value="新增">
            	</form>
            </div>
            <div class="list">
              <ul>
				<?php
    				try {
          			 	 $conn = _dbconnect();
          			 	 $stid=_GroupSelect($uno);
          			foreach ($stid as $row ) {
				?>
                <li>
                  <!--G_Display-->
                  <div class="name"><a href="index.php ?GNO=<?php echo $row["GNO"]?>&
                                                        GNAME=<?php echo $row["TITLE"]?>&
                                                        SETVIEW=list">
                  	  
                  	<?php echo $row["TITLE"];?></a>
                 </div>

                  
                  <div class="tool">
                  <!--G_EDIT-->
                  <form action="Main.php" method="get">
            		<input type="hidden" name="UNO" value="<?php echo($uno)?>">
            		<input type="hidden" name="GNO" value="<?php echo $row["GNO"]?>">
            		<input type="hidden" name="set" value="G_EDIT">
            		<input type="text" name="EDIT_TITLE" placeholder="修改內容"> 
            	 	<input type="submit" value="修改">&nbsp;&nbsp;&nbsp;
            	  </form>


                  <!--G_DELETE-->
                    <a href="Main.php ?UNO=<?php  echo $uno?>&
                                       GNO=<?php  echo $row["GNO"]?>&
                                       set=G_DEL"class="delete">刪除</a>
                  </div>
                </li>
				<?php 
     				 }
      				  } 
      				catch (PDOException $e) {
            		   return ("DB connect Error!: $e->getMessage()");
            		   die();
      				}
				?>
              </ul>
            </div>
          </div>
        </div>
        <!--清單-->
        <div class="page" v-if="list[1].page==true">
          <div class="title">類別：【<?php echo $gname ?>】</div>
          <div class="content">
          	<div class="name" style="text-align:center;"><font size ="4"face="DFKai-sb">清單</font></div>
            <div class="tool">
            	<!--L_CREATE-->
            	<form action="Main.php" method="get">
            		<input type="hidden" name="UNO" value="<?php echo($uno)?>">
            		<input type="hidden" name="GNO" value="<?php echo $gno?>">
            		<input type="hidden" name="set" value="L_CREATE">
            		<input type="text" name="TITLE" placeholder="新增清單名稱">
            	 	<input type="submit" value="新增">
            	</form>
            </div>
            <div class="list">
              <ul>
              <?php
    				try {
          			 	 $conn=_dbconnect();
          			 	 $stid=_ListSelect($uno,$gno);
          			foreach ($stid as $row) {
				?>

                <li>
                　
                  <!--L_DISPLAY-->
                  <div class="name">
                  	<a href="index.php ?UNO=<?php  echo $uno?>&
                                        GNO=<?php  echo $gno?>&
                                        LNO=<?php  echo $row["LNO"]?>&
                                        GNAME=<?php echo $gname?>&
                                        LNAME=<?php echo $row["TITLE"]?>&
                                        SETVIEW=item"
                                        >
                                       	<?php echo $row["TITLE"]?>

                  </a></div>
                  <div class="tool">


                  <!--LIST_SHARE-->
                  <form action="Main.php" method="get">
                    <input type="hidden" name="UNO" value="<?php  echo($uno)?>">
                    <input type="hidden" name="GNO" value="<?php  echo($gno)?>">
                    <input type="hidden" name="LNO" value="<?php  echo $row["LNO"];?>">
                    <input type="hidden" name="set" value="L_SHARE">
                    <input type="text"   name="SNO" placeholder="分享對象ID" >&nbsp;
                    <a><input type="submit" value="分享">&nbsp;&nbsp; </a>
                  </form>


                  <!--L_EDIT-->
                  <form action="Main.php" method="get">
            		<input type="hidden" name="UNO" value="<?php echo($uno)?>">
            		<input type="hidden" name="GNO" value="<?php echo($gno)?>">
            		<input type="hidden" name="LNO" value="<?php echo $row["LNO"]?>">
            		<input type="hidden" name="set" value="L_EDIT">
            		<input type="text" name="EDIT_TITLE" placeholder="修改內容"> 
            	 	<input type="submit" value="修改">&nbsp;&nbsp;&nbsp;
            	  </form>
                    <!--a href="http://" class="edit"></a 修改的標籤-->

                    <!--L_DEL-->
                    <a href="Main.php ?UNO=<?php  echo $uno?>&
                                       GNO=<?php  echo $gno?>&
                                       LNO=<?php  echo $row["LNO"]?>&
                                       set=L_DEL"class="delete">刪除</a>
                  </div>
                </li>
                <?php 
     				 }
      				  } 
      				catch (PDOException $e) {
            		   return ("DB connect Error!: $e->getMessage()");
            		   die();
      				}
				?>
              </ul>
            </div>
          </div>
        </div>
        <!--項目-->
        <div class="page" v-if="list[2].page==true">
          <div class="title">【<?php echo $lname?>】清單</div>
          <div class="content">
          	<div class="name" style="text-align:center;"><font size ="4"face="DFKai-sb">項目</font></div>
            <div class="tool">
            	<!--I_CREATE-->
            	<form action="Main.php" method="get">
            		<input type="hidden" name="UNO" value="<?php echo($uno)?>">
            		<input type="hidden" name="GNO" value="<?php echo $gno?>">
            		<input type="hidden" name="LNO" value="<?php echo $lno?>">
            		<input type="hidden" name="GNAME" value="<?php echo $uname?>">
            		<input type="hidden" name="set" value="I_CREATE">
            		<input type="text"   name="CONTENT" placeholder="新增項目內容">
            	 	<input type="submit" value="新增">
            	</form>
            </div>
            <div class="list">
              <ul>
              	<?php
    				try {
          			 	 $conn = _dbconnect();
          			 	 $stid=_ItemSelect($uno,$gno,$lno);
          				 foreach ($stid as $row) {
				?>
                <li> 
                  <!--I_DISPLAY-->
                  <div class="name"><a><?php echo $row["CONTENT"]?></a></div>
                  <div class="tool">
                  
                  <!--I_EDIT-->
                  <form action="Main.php" method="get">
            		<input type="hidden" name="UNO" value="<?php echo $uno?>">
            		<input type="hidden" name="GNO" value="<?php echo($gno)?>">
            		<input type="hidden" name="LNO" value="<?php echo($lno)?>">
            		<input type="hidden" name="INO" value="<?php echo $row["INO"]?>">
            		<input type="hidden" name="set" value="I_EDIT">
            		
            		<input type="text" name="EDIT_ITEM" placeholder="修改項目內容"> 
            	 	<input type="submit" value="修改">&nbsp;
                <?php 
                  if(strlen($row["ONCHECK"])!="")
                  {
                    echo '<a href="Main.php ?SNO='.$uno.'&';
                    echo  'GNO='.$gno.'&';
                    echo  'LNO='.$lno.'&';
                    echo  'INO='.$row["INO"].'&';
                    echo  'UNO='.$_SESSION["UNO"].'&';
                    echo  'set=I_UNCHK">已確認</a>&nbsp;';
                  }else{
                    echo '<a href="Main.php ?SNO='.$uno.'&';
                    echo  'GNO='.$gno.'&';
                    echo  'LNO='.$lno.'&';
                    echo  'INO='.$row["INO"].'&';
                    echo  'UNO='.$_SESSION["UNO"].'&';                    
                    echo  'set=I_CHK">未確認</a>&nbsp;';
                  }

                ?>
            	 	<!-- <input type="checkbox" id="check" onclick="check()" >&nbsp;&nbsp;&nbsp; -->
            	  </form>
                    <!--a href="http://" class="edit">編輯</a-->

                    <!--I_DEL-->
                    <a href="Main.php ?UNO=<?php  echo $uno?>&
                                        GNO=<?php  echo $gno?>&
                                        LNO=<?php  echo $lno?>&
                                        INO=<?php  echo $row["INO"]?>&
                                        set=I_DEL"class="delete">刪除</a>
                  </div>
                </li>
            	 <?php 
     				 }
      				   } 
      				catch (PDOException $e) {
            		   return ("DB connect Error!: $e->getMessage()");
            		   die();
      				}
				?>
              </ul>
            </div>
          </div>
        </div>
        <!--被分享之清單-->
        <div class="page" v-if="list[3].page==true">
          <div class="title">【<?php echo $uname ?>】的{{list[3].name}}</div>
          <div class="content">
            <div class="list">
              <ul>
                <?php
    				try {
          			 	 $conn = _dbconnect();
          			 	 $stid=_BEShareselect($uno);
          				 foreach ($stid as $row) {
				?>
                <li>
                  <div class="name"><a href="http://"><?php echo $row["TITLE"];?> ｜
                  <FONT>擁有者ID：【<?php echo $row["UNO"];?></FONT>】
                  </a></div>
                  <div class="tool">
                     <a href="Main.php?SNO=<?php echo($uno)?>&
                     				   GNO=<?php echo $row["GNO"];?>&
                     				   LNO=<?php echo $row["LNO"];?>&
                     				   UNO=<?php echo $row["UNO"];?>&
                                       set=BES_Cancel"
                        class="delete">刪除</a>
                  </div>
                </li>
                <?php 
     				 }
      				   } 
      				catch (PDOException $e) {
            		   return ("DB connect Error!: $e->getMessage()");
            		   die();
      				}
				?>
              </ul>
            </div>
          </div>
        </div>
         <!--分享之清單-->
        <div class="page" v-if="list[4].page==true">
          <div class="title">【<?php echo $uname ?>】的{{list[4].name}}</div>
          <div class="content">
            <div class="list">
              <ul>
         		  <?php
    				try {
          			 	 $conn = _dbconnect();
          			 	 $stid=_Shareselect($uno);
          				 foreach ($stid as $row) {
				?>
                <li>
                  <div class="name"><a href="http://">
                  	<?php echo $row["TITLE"];?>清單 | 分享者ID:【<?php echo $row["SNO"];?>】	
                  </a></div>
                  <div class="tool">
                    <a href="Main.php? UNO=<?php echo($uno)?>&
                     				   GNO=<?php echo $row["GNO"];?>&
                     				   LNO=<?php echo $row["LNO"];?>&
                     				   SNO=<?php echo $row["SNO"];?>&
                                       set=S_Cancel"
                        class="delete">刪除</a>
                  </div>
                </li>
               	 <?php 
     				 }
      				   } 
      				catch (PDOException $e) {
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
  </div>
  <script src="js/main.js"></script>

</body>

</html>