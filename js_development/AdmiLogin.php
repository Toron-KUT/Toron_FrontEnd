<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <title>管理者・店長ログインページ</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link rel="stylesheet" href="base.css" type="text/css" media="screen" />
    <script type = "text/javascript">
  <!--
  function AuthentivationUsed(){
  //  <!--Webページでログインする際に、入力されたログイン情報がデータベースに登録されているか問い合わせを行うメソッドである-->

  var login_id = document.getElementById("login_id").value;
  var password = document.getElementById("login_pass").value;
  var Data = [[("login_id"),login_id],[("password"),password]];
  var JSONData =JSON.stringify(Data);
  <?php //include("getLoginInfo.php"); ?>
  $.post (
    "webLogin.php",
    {"JSON":JSONData},
    function (data) {
      //alert(data_arr);
    }
  );
  //  <!--戻り値はidentifi-->
    changepage(IdentificationNumbe);
  }
  function changepage(IdentificationNumber) {


    var IdentificationNumber = 2;
    if (IdentificationNumber == 0) {
    //  <!--管理社-->
      window.location.replace = "AdmiSale.html";
    } else if (IdentificationNumber == 1) {
      //<!--店長-->
      window.location.replace = "AdmiSpecialPrise.html";
    } else {
      window.location.replace = "AdmiSpecialPrise.html";//テスト用
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
  <input name="button" type="button" value="送信" onClick="AuthentivationUsed">
</form>

</body>
</html>