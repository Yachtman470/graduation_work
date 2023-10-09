<?php
session_start();
//0. 関数群の読み込み
include("funcs.php");
sschk();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ユーザー登録</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<?php include "header.html" ?>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="us_insert.php">
  <div class="jumbotron">
   <fieldset>
    <legend>ユーザー登録</legend>
     <label>ユーザー名：<input type="text" name="name"></label><br>
     <label>ログインID：<input type="text" name="lid"></label><br>
     <label>ログインPW：<input type="password" name="lpw"></label><br>
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->

</body>
</html>
