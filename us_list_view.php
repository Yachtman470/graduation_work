<?php
session_start();
//0. 関数群の読み込み
include("funcs.php");
sschk();

//1. DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  $pdo = db_conn();      //DB接続関数
} catch (PDOException $e) {
  exit('DBConnection Error:'.$e->getMessage());
}

//２．データ登録SQL作成
$sql = "SELECT * FROM gs_user_table;";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false) {
  //SQLエラーの場合
  sql_error($stmt);
}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= '<a href="us_update_view.php?id='.h($r["id"]).'">';
    $view .= h($r["id"])." | ".h($r["name"])." | ".h($r["lid"]);
    $view .= '</a>';
    $view .= '<a href="us_delete.php?id='.h($r["id"]).'">';
    $view .= "[削除]<br>";
    $view .= '</a>';
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ユーザー表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<?php include "header.html" ?>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <div class="container jumbotron"><?=$view?></div>
</div>
<!-- Main[End] -->

</body>
</html>
