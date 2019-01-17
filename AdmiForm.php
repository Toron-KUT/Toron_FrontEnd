<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ja" xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Style-Type" content="text/css" />

    <title>管理者用店舗管理ページ</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
    <link rel="stylesheet" href="base.css" type="text/css" media="screen" />
    <script type="text/javascript">
    var data =[];
    //data = JSON.parse(;
    window.onload = function(){
     var test =<?php include("showStore.php") ?>;

  //  var store_data =
var test = <?php echo $store_data;//json_encode($store_data); ?>;
console.log(test);
//var mydata = JSON.parse(test);
    alert(test);

   creatTable(mydata);
}
    </script>
    <script type="text/javascript">


    //テーブルに追加する前に、null判定と配列に追加
    function creatdata() {
      if(count_col != 1 && editFlag !=1){
            var table = document.getElementById("table");
            var shopName = document.getElementById ("shopName").value;
            var shopID = document.getElementById ("shopID").value;
            var userID = document.getElementById ("userID").value;

            if ((shopID && shopName && userID) == ""){//空白チェック
             alert("空欄があります");
           } else if(shopID.match(/[^0-9]+/)){//数字チェック
             alert("IDに数字以外が入力されています");
           } else {
              var data = [shopID, shopName, userID];
            //  var t =JSON.stringify(data);
            //  alert(t);
              creatTable(data);
            }
          }
    }
    function creatTable(data){
      // 表の作成開始
      var table = document.getElementById("table");
      // 表に2次元配列の要素を格納
      table.style.border ="1px solid";         //枠
        var rows = table.insertRow(-1);        // 新しい行の追加//-1で下に追加する
          for(j = 0; j < 3; j++){
            var  cell=rows.insertCell(-1);    //列
              cellNode = document.createTextNode(data[j]);
              cell.appendChild(cellNode);     //データノードの作成、ノードの連結
              cell.style.border ="1px solid"; //枠
          }
    }

    var count_col=0;
    var editFlag = 0;
    function deleteTable(id) {
      count_col +=1;
      if(count_col ==1){
      var table = document.getElementById("table");
      var rows = table.rows.length;

      //
      for (var i = 0; i < rows; i ++) {
        if(i == 0)continue;
        var cell = table.rows[i].insertCell(-1);

    //  alert();
    if(id=="delete"){
    cell.innerHTML = '<input type="button" value="削除" name="addDelete" onclick="dB(this)">';
  } else if(id=="edit"){
      cell.innerHTML = '<input type="button" value="編集" name="addDelete" onclick="editTable(this, name)">';
  }
      }
      var newButton = document.createElement("BUTTON");
      newButton.textContent="編集終了";
      document.getElementById("table").appendChild(newButton);
      //--編集終了のボタンを押したときの反応
                newButton.onclick= function() {
                  var table = document.getElementById("table");
                  var rows = table.rows.length;

      // 削除を削除
                  for ( var i = 0; i < rows; i++) {
                    if (i == 0) continue;
                    table.rows[i].deleteCell(-1);
                  }
                  newButton.parentNode.removeChild(newButton);

                  count_col = 0;
                  if(editFlag == 2) editFlag=0;

      }
}

    }
    var cellOne =[];
    var newText =[];
function editTable(obj, name) {
  editFlag = 1;
  var table = document.getElementById("table");


  tr = obj.parentNode.parentNode;
  var rows2 = tr.sectionRowIndex;
if(name == "perf"){
  editFlag = 2;
   newText[0] = document.getElementById("newForm1").value;
    newText[1] = document.getElementById("newForm2").value;
     newText[2] = document.getElementById("newForm3").value;
//  var cellNode = document.createTextNode(newText[0]);
//alert(newText[0]);
}

for(var i = 0;i<4;i++){
  if(i != 3 && name !="perf"){
 cellOne[2-i] = table.rows[rows2].cells[2-i].innerHTML;
 //alert(cellOne[2-i]);
}
//alert();
table.rows[rows2].deleteCell(-1);
}

  if(name =="perf"){

for (var i=0; i<4;i++) {

    var cell = table.rows[rows2].insertCell(-1);
    if(i<3){
    cell.innerHTML =newText[i];
} else {
   cell.innerHTML = '<input type="button" value="編集" name="addC" onclick="editTable(this, name)">';
}
}

  }else{

var cell = table.rows[rows2].insertCell(-1);
  cell.innerHTML = '<input id="newForm1" type="text" name="newForm1" size="8">';
  document.getElementById("newForm1").value =cellOne[0];
  var cell = table.rows[rows2].insertCell(-1);
  cell.innerHTML = '<input id="newForm2" type="text" name="newForm2" size="8">';
  document.getElementById("newForm2").value =cellOne[1];
  var cell = table.rows[rows2].insertCell(-1);
  cell.innerHTML = '<input id="newForm3" type="text" name="newForm3" size="8">';
  document.getElementById("newForm3").value =cellOne[2];
var cell = table.rows[rows2].insertCell(-1);


cell.innerHTML = '<input type="button" value="修正完了" name="perf" onclick="editTable(this,name)">';
}
}
    function dB(obj) {
      tr = obj.parentNode.parentNode;
      tr.parentNode.deleteRow(tr.sectionRowIndex);
    }

    </script>
  </head>
  <body>
    <div id="wrapper">
    <div id="contents">
    <!--  <h1>*** 株式会社マルナカ | 店舗管理ページ***</h1>
    --> <h3> <p class="logo">*** 株式会社マルナカ | 店舗管理ページ***</p></h3>
      <p class="description">*** 管理者専用ページです。登録店舗の編集を行えます ***</p>
  <h5>***新規店舗登録フォームはこちら***</h5>
    <form><!--入力フォーム-->
      <div><!--かたまりみたいな-->
      店舗ID　　:
      <input id ="shopID" name="shopID" type="text" size="15"><br>
      店舗名　　:
        <input id="shopName" name="shopName" type="text" size="30"><br>
      店長ユーザID　:
        <input id ="userID" name="userID" type="text" size="15">
  　      　  <input name="button" type="button" value="登録" onClick="creatdata()">
      </div>
    </form>
    <h5>***登録された店舗***</h5>

    <input id="delete"name="delete" type="button" value="登録情報の削除" onClick="deleteTable(id)" style="position: relative; left: 370px; top: 0px;">
    <input id="edit"name="edit" type="button" value="登録情報の編集" onClick="deleteTable(id)"  style="position: relative; left: 370px; top: 0px;">
    <br><br>
    <table border="1" id = "table">
      <tr>
        <th>店舗コード</th><th>店舗名</th><th>店長ユーザID</th>
      </tr>
    </table>
    <div align="right">
      <p >*** サイト内リンク ***</p>
      <ul class="localnavi">
        <li><a href="AdmiForm.html"> 店舗管理ページ </a></li>
        <li><a href="AdmiSale.html"> 特売情報管理ページ </a></li>
      </ul>
    </div>
    <div align="right">
     <input name="button" type="button" value="ログアウト" onClick="location.href='./AdmiLogin.html'">
   </div>
  </body>
</html>
