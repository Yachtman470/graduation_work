<?php
session_start();
//0. 関数群の読み込み
include("funcs.php");
sschk();

//１．PHP
$id = $_GET["id"];
$pdo = db_conn();      //DB接続関数

//２．データ登録SQL作成
$stmt   = $pdo->prepare("SELECT * FROM transport_table WHERE id=:id"); //SQLをセット
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
  <title>運行便更新</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="tr_register.php">運行便登録</a></div>
    <div class="navbar-header"><a class="navbar-brand" href="tr_list_view.php">運行便表示</a></div>
    <?php if ($_SESSION['kanri_flg'] == 1) : ?>
      <div class="navbar-header"><a class="navbar-brand" href="us_register.php">ユーザー登録</a></div>
      <div class="navbar-header"><a class="navbar-brand" href="us_list_view.php">ユーザー表示</a></div>
      <!-- endifとセミコロンで閉じる -->
    <?php endif; ?>
    <div class="navbar-header"><a class="navbar-brand" href="logout.php">ログアウト</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="POST" action="tr_update.php">
  <div class="jumbotron">
   <fieldset>
    <legend>運行便編集</legend>
     <label>社名：<input type="text" name="name"></label><br>
     <!-- <label>ルート：<input type="text" name="route"></label><br> -->
     <label>ルート：</label>
     <select name='route'>
     <option value='大阪→東京'>大阪→東京</option>
     <option value='東京→大阪'>東京→大阪</option>
     </select><br>
     <label>出発日：<input type="date" name="departure"></label><br>
     <label>到着日：<input type="date" name="arrival"></label><br>
     <label>貨物サイズ：<input type="int" name="size"></label><br>
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




