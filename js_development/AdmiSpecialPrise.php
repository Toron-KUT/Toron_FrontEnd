
<?php

  if(empty($_POST['test2'])){

      header("LOCATION: AdmiLogin.php" );
  }
?>
<!DOCTYPE html >
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <title>特価情報管理ページ</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link rel="stylesheet" href="base.css" type="text/css" media="screen" />
    <script src="http://code.jquery.com/jquery.min.js"></script>
    <script type = "text/javascript">
      var data_insert =[];
      var select1_data =["野菜・果物","肉・卵","魚介類","米・パン・粉類",
                        "乳製品","惣菜","インスタント・レトルト",
                        "菓子・冷凍","飲料水","その他(食品)","その他(食品外)"];
    //  var select2_data =[["野菜","キャベツ","きゅうり"],["肉","牛肉","鶏肉","豚肉"],["リンゴ"],["刺身"]];
    var select2_data  =[];
    var suf = [0,0,0,0,0,0,0,0,0,0,0];//カテゴリの数カウント添え字
    var sel4 = []
          window.addEventListener("load", function(){
//console.log(suf);
            for (var i = 0; i < select1_data.length; i++) {
              select2_data[i]  = [];
              sel4[i] = [];
              select2_data[i][0] = select1_data[i];
              sel4[i][0] = select1_data[i];

            }
        <?php include("http://krlab.info.kochi-tech.ac.jp/~goohira/php/showProductData.php") ?>;
        var test = '<?php echo $product_data;?>';
        var mydata = JSON.parse(test);
        //console.log(mydata);
      //  for (var cat_con = 0;cat_con < select1_data.length ;cat_con++) {

        //  select2_data[cat_con][0] = select1_data[i];
          for (var j = 0; j < mydata["product_data"].length;j++) {

//console.log(suf[con-1]);
          //  if(mydata["price"][j]["categry_id"] == cat_con)
          var con = mydata["product_data"][j]["category_id"];
          suf[con-1]++;

          select2_data[con-1][suf[con-1]] = mydata["product_data"][j]["name"];
          sel4[con-1][suf[con-1]] = mydata["product_data"][j]["price"];
          }

            var store_id = 1;
            var data = {
              store_id : store_id
            }
            $.ajax({
              type:"post",
              url:"http://krlab.info.kochi-tech.ac.jp/~goohira/php/showSpecialPrice.php",
              data:JSON.stringify(data),
              contentType: 'Content-Type: application/json; charset=UTF-8',
            }).done(
              function(data){
              //  console.log(data);
                //var log = JSON.parse(data);
                if(data != "") {
                  var mydata = JSON.parse(data);
                //  console.log(mydata);
                  for (var i = 0; i < mydata["sp_price"].length; i++){
                    data_insert[i] = [];
                    data_insert[i][0] = select1_data[mydata["sp_price"][i]["category_id"] - 1];
                    data_insert[i][1] =mydata["sp_price"][i]["name"];
                    data_insert[i][2] =mydata["sp_price"][i]["price"];
                    if (mydata["sp_price"][i]["rateFlg"] ==  "1") {
                      data_insert[i][3] =data_insert[i][2] * (1 - mydata["sp_price"][i]["discntVal"] * 0.01);
                    } else {
                      data_insert[i][3] =data_insert[i][2] - mydata["sp_price"][i]["discntVal"];
                    }
                  }
                  creatTable(data_insert);
                } else if(data == ""){
                  alert("情報取得ができませんでした。リロードしてください");
                  console.log(data);
                }

              }).fail(
              function() { //失敗した時
                alert("通信エラーです。もう一度入力してください");
              }
            );

    }, false)
       </script>

  <script type = "text/javascript">
  function SetChoice1() {
      var select1 = document.forms.formName.selectName1; //変数select1を宣言
      select1.options.length = 0;
      select1.options[0] = new Option("選択してください");
      var select2 = document.forms.formName.selectName2; //変数select2を宣言


      for(var i = 0;i<select1_data.length - 1;i++){
        select1.options[i+1]=new Option(select1_data[i]);
      }

  }
  function SetChoice2() {
    var select1 = document.forms.formName.selectName1;
    var select2 = document.forms.formName.selectName2; //変数select1を宣言
    select2.options.length = 0;
    select2.options[0] = new Option("選択してください");

    for(var i = 0;i<select1_data.length-1;i++){
      if(select1.options[select1.selectedIndex].value != select1_data[i]) continue;

      for (var j = 0;j <select2_data[i].length -1;j++) {
      select2.options[j+1]=new Option(select2_data[i][j+1]);
    }
  }
}
  function creatdata() {
    if((count_col || editFlag) != 1 ){
      var select1 = document.forms.formName.selectName1;
      var select2 = document.forms.formName.selectName2; //変数select1を宣言
      var select3 = document.forms.formName.selectName3;
      var sel1 = select1.options[select1.selectedIndex].value;
      var sel2 = select2.options[select2.selectedIndex].value;
      var sel3 = select3.options[select3.selectedIndex].value;
      var sel_genka = sel4[select1.selectedIndex-1][select2.selectedIndex];
      if ((sel3 - 0) < 1) {
      var sel_price = Math.floor((sel4[select1.selectedIndex-1][select2.selectedIndex]-0) * (sel3-0));
      var discntVal = sel3 * 100;
      var rate = 1;
      //alert();
      //sel_price = Math.floor(sel_price);
    } else {
      var sel_price = Number(sel4[select1.selectedIndex-1][select2.selectedIndex]) - Number(sel3);
      var rate = 0;
    }

    //  console.log(Number(sel4[select1.selectedIndex-1][select2.selectedIndex])- sel3);
          if ((sel1 || sel2 || sel3)  == "選択してください"){//空白チェック
           alert("選択してください");
         } else {
            var data_arr = [[sel1, sel2, sel_genka, sel_price]];
            var data = {
              product_name : sel1,
              discntVal : discntVal,
              rateFlg : rate,
              store_id : "1"
            }
            $.ajax({

              type:"post",
            //  dataType: "json",
              url:"http://krlab.info.kochi-tech.ac.jp/~goohira/php/insertSpecialPrice.php",
              data:JSON.stringify(data),
              contentType: 'Content-Type: application/json; charset=UTF-8', // リクエストの Content-Type
            //  dataType: "json"

            }).done(
              function(data){
                console.log(data);
                //var log = JSON.parse(data);
                if(data == "true") {

                    creatTable(data_arr);
                } else if(data == "false") {

                  alert("もう一度入力してください");
                  console.log(data);
                } else {
                  alert("情報取得ができませんでした。もう一度入力してください");
                  console.log(data);

                }

              }).fail(
              function() { //失敗した時
                alert("通信エラーです。もう一度入力してください");
              }
            );


          }
        }
  }
  function creatTable(data){
    // 表の作成開始
    var table = document.getElementById("table");
    // 表に2次元配列の要素を格納
    table.style.border ="1px solid";         //枠
      for (var i = 0; i<data.length; i++){
      var rows = table.insertRow(-1);        // 新しい行の追加//-1で下に追加する
        for(var j = 0; j < data[0].length; j++){
          var  cell=rows.insertCell(-1);    //列
            cellNode = document.createTextNode(data[i][j]);
            cell.appendChild(cellNode);     //データノードの作成、ノードの連結
            cell.style.border ="1px solid"; //枠
        }
      }
  }

  var count_col=0;
  var editFlag = 0;
  function deleteTable() {
    count_col +=1;
    if(count_col ==1){


    var table = document.getElementById("table");
    var rows = table.rows.length;


    //
    for (var i = 0; i < rows; i ++) {
      if(i == 0)continue;
      var cell = table.rows[i].insertCell(-1);

  //  alert();
  cell.innerHTML = '<input type="button" value="削除" name="addDelete" onclick="dB(this)">';
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

    }
}

  }

  function dB(obj) {
    tr = obj.parentNode.parentNode;
  var rows2 = tr.sectionRowIndex;
    //tr.parentNode.deleteRow(tr.sectionRowIndex);
    var data = {
      product_name : table.rows[rows2].cells[1].innerHTML,
      store_id : 1
    }
    console.log(data);
    $.ajax({

      type:"post",
      url:"http://krlab.info.kochi-tech.ac.jp/~goohira/php/deleteSpecialPrice.php",
      data:JSON.stringify(data),
      contentType: 'Content-Type: application/json; charset=UTF-8', // リクエストの Content-Type

    }).done(
      function(data){
        console.log(data);
        if(data == "true") {
        tr.parentNode.deleteRow(tr.sectionRowIndex);
        } else if(data == "false"){
          alert("エラーです。削除できませんでした");
        }else {
          alert("なにもかえってないぞ");
        }
      }).fail(
      function() { //失敗した時
        alert("通信エラーです。");
      }
    );
  }

  function SetUpdataSpecialSale(){
    editFlag +=1;
    if(editFlag ==1){


    var table = document.getElementById("table");
    var rows = table.rows.length;


    //
    for (var i = 0; i < rows; i ++) {
      if(i == 0)continue;
      var cell = table.rows[i].insertCell(-1);

  //  alert();
  cell.innerHTML = '<input type="button" value="soldout" name="addDelete" onclick="chengeColor(this)">';
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

              editFlag= 0;

    }
}
}
function chengeColor(obj) {
  tr = obj.parentNode.parentNode;
  var rows2 = tr.sectionRowIndex;
  var data = {
    product_name : table.rows[rows2].cells[1].innerHTML,
    store_id : 1
  }
  console.log(data);
  $.ajax({

    type:"post",
    url:"http://krlab.info.kochi-tech.ac.jp/~goohira/php/soldout.php",
    data:JSON.stringify(data),
    contentType: 'Content-Type: application/json; charset=UTF-8', // リクエストの Content-Type

  }).done(
    function(data){
      console.log(data);
      if(data == "true") {
        tr.style.color = "red";
      } else if(data == "false"){
        alert("エラーです。削除できませんでした");
      }else {
        alert("なにもかえってないぞ");
      }
    }).fail(
    function() { //失敗した時
      alert("通信エラーです。");
    }
  );

}
  </script>
</head>


<!--以下通常のドロップボタン-->
<body bgcolor onLoad="SetChoice1()">
  <div id="wrapper">
  <div id="contents">
   <h3> <p class="logo">*** 株式会社マルナカ | 特価情報管理ページ***</p></h3>
    <p class="description">*** 管理者専用ページです。特価情報の編集を行えます ***</p>
      <h5>特価情報選択</h5>
<form name="formName" method="post" action="./pathToProgramFile">
<!--選択肢その1-->
<select name = "selectName1" onChange="SetChoice2()">

</select>

<!--選択肢その2（選択肢その1の項目によって変化）-->
<select name = "selectName2">
  <option value = "選択してください">選択してください</option>
</select>
<select name = "selectName3">
<option value = "選択してください">選択してください</option>
<option value = "0.9">10%</option>
<option value = "0.8">20%</option>
<option value = "0.7">30%</option>
<option value = "0.6">40%</option>
<option value = "0.5">50%</option>
<option value = "10">10円引き</option>
<option value = "20">20円引き</option>
<option value = "30">30円引き</option>
<option value = "50">50円引き</option>
<option value = "100">100円引き</option>
<option value = "150">150円引き</option>

</select>
<input name="button" type="button" value="登録" onClick="creatdata()">
<h5>登録された商品</h5>
<input name="delete" type="button" value="登録情報削除" onClick="deleteTable()">
<input name="delete" type="button" value="品切れ商品の登録" onClick="SetUpdataSpecialSale()">
<br><br>
<table border="1" id = "table">
  <tr>
    <th>商品カテゴリ</th><th>商品名</th><th>定価</th><th>商品価格</th>
  </tr>
  <div align="right">
   <input name="button" type="button" value="ログアウト" onClick="location.href='./AdmiLogin.php'">
 </div>
</table>
</body>
</html>
