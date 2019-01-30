<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <title>管理者・店長ログインページ</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
      <script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
      <script src="http://code.jquery.com/jquery.min.js"></script>
    <link rel="stylesheet" href="base.css" type="text/css" media="screen" />
    <script type = "text/javascript">
  <!--
  function AuthentivationUsed(){
  //  <!--Webページでログインする際に、入力されたログイン情報がデータベースに登録されているか問い合わせを行うメソッドである-->

  var login_id = document.getElementById("login_id").value;
  var password = document.getElementById("login_pass").value;
//  var Data = [[("login_id"),login_id],[("password"),password]];
  var data = {
    login_id : login_id,
    password :password
  };
  console.log(data);
//  alert("1");
    $.ajax({
    type:"post",
  //  dataType: "json",
    url:"webLogin.php",
    data:JSON.stringify(data),
    contentType: 'Content-Type: application/json; charset=UTF-8', // リクエストの Content-Type
  //  dataType: "json"

  }).done(
    function(data){
    //  console.log(data);
//var res = JSON.parse(data);
  //    console.log(res);
    //  alert("3");
console.log(data);

      if(data != "") {
        console.log(data);
        var res = JSON.parse(data);
        var IdentificationNumbe =res["flg"]; //res[info][0];
          console.log(IdentificationNumbe);
       if (IdentificationNumbe  != "0") {
         changepage(IdentificationNumbe);
       } else {
         alert("あなたは利用できません。もしくはログイン情報が間違っています")
       }

     } else if(data == ""){
        alert("入力情報が間違っている可能性があります");
        console.log(data);
      }

    }).fail(
    function() { //失敗した時
      alert("通信エラーです。もう一度入力してください");
    }
  );
  //  <!--戻り値はidentifi-->

  }

  function changepage(IdentificationNumber) {

//alert();
  //  var IdentificationNumber = 2;
    if (IdentificationNumber == "2") {
      document.forms[1].submit();
      //window.location.replace("AdmiSale.php");
    } else if (IdentificationNumber == "1") {
      //<!--店長-->
      //window.location.replace("AdmiSpecialPrise.php");
      document.forms[2].submit();
    } else {
      alert("ログイン情報に誤りがあります");
    }
  }
  //-->
  </script>
</head>
<body>
  <div id="wrapper">
  <div id="contents">
    <h3><p class="logo" >管理者・店長専用ログインページ</p></h3>
     <p class="description"></p>
<h5>管理者・店長ログインフォーム</h5>
<form>
　　　　　ID　:
  <input id="login_id" name="login_id" type="text" size="30">
<br>
  PassWord　:
    <input id="login_pass" name="login_pass" type="password" size="30">
  <input name="button" type="button" value="送信" onClick="AuthentivationUsed()">
</form>

<form method="POST" action="AdmiSale.php">
    <input type="hidden" name="test" value='sucsess'>
</form>

<form method="POST" action="AdmiSpecialPrise.php">
    <input type="hidden" name="test2" value='sucess'>
</form>

</body>
</html>
