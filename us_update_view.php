<?php
session_start();
//0. 関数群の読み込み
include("funcs.php");
sschk();

//１．PHP
$id = $_GET["id"];
$pdo = db_conn();      //DB接続関数

//２．データ登録SQL作成
$stmt   = $pdo->prepare("SELECT * FROM gs_user_table WHERE id=:id"); //SQLをセット
$stmt->bindValue(":id", $id, PDO::PARAM_INT);
$status = $stmt->execute(); //SQLを実行→エラーの場合falseを$statusに代入

//３．データ表示
$view=""; //HTML文字列作り、入れる変数
if($status==false) {
  //SQLエラーの場合
  sql_error($stmt);
}else{
  $row = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ユーザー更新</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<?php include "header.html" ?>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="POST" action="us_update.php">
  <div class="jumbotron">
   <fieldset>
    <legend>ユーザー編集</legend>
     <label>ユーザー名：<input type="text" name="name" value="<?=$row["name"]?>"></label><br>
     <label>ログインID：<input type="text" name="lid" value="<?=$row["lid"]?>"></label><br>
     <label>ログインPW：<input type="password" name="lpw" value=""></label><br>
     <!-- idを隠して送信 -->
     <input type="hidden" name="id" value="<?=$row["id"]?>">
     <!-- idを隠して送信 -->
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>




