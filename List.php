<?php
	include_once "../Main.php"; 
	$uno = _SESSION['UNO']
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
            <div class="tool"><a href="#">add+</a></div>
            <div class="list">
              <ul>
                <li>
                  <div class="name"><a href="http://">work</a></div>
                  <div class="tool">
                    <a href="http://" class="edit">編輯</a>
                    <a href="http://" class="delete">刪除</a>
                  </div>
                </li>
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