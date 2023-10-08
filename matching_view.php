<?php
session_start();
//0. 関数群の読み込み
include("funcs.php");
sschk();

//1. DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  $id = $_GET["id"];
  $pdo = db_conn();      //DB接続関数
} catch (PDOException $e) {
  exit('DBConnection Error:'.$e->getMessage());
}

//２．データ登録SQL作成
// $sql = "SELECT * FROM transport_table;";
$sql = "SELECT * FROM transport_table WHERE id=:id;";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $id, PDO::PARAM_INT);
$status = $stmt->execute();
if($status==false) {
  //SQLエラーの場合
  sql_error($stmt);
}else{
  $row = $stmt->fetch();
  $departure = $row["departure"];
  $arrival = $row["arrival"];
  $size = $row["size"];
  $route_a = $row["route"];
  switch($route_a){
    case "大阪→東京":
      $route_b = "東京→大阪";
      break; //switch文から抜ける。
    case "東京→大阪":
      $route_b = "大阪→東京";
      break; //switch文から抜ける.
    case "大阪→福岡":
        $route_b = "福岡→大阪";
        break; //switch文から抜ける。
    case "福岡→大阪":
          $route_b = "大阪→福岡";
          break; //switch文から抜ける。
    case "東京→仙台":
            $route_b = "仙台→東京";
            break; //switch文から抜ける.         
 case "仙台→東京":
            $route_b = "東京→仙台";
            break; //switch文から抜ける.
    default: //$valの値が上記に当てはまらない場合に時実行される。
    
    break; //switch文から抜ける.
}
}

//２．データ登録SQL作成
// $sql = "SELECT * FROM transport_table WHERE id=:id;";
$sql = "SELECT * FROM transport_table WHERE route=:route AND departure=:departure AND arrival=:arrival;";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":route", $route_b, PDO::PARAM_STR);
$stmt->bindValue(":departure", $departure, PDO::PARAM_STR);
$stmt->bindValue(":arrival", $arrival, PDO::PARAM_STR);
$status = $stmt->execute();

//３．データ表示
$view="";
// echo($_SESSION['lid']);
if($status==false) {
  //SQLエラーの場合
  sql_error($stmt);
}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){
    if ($r["lid"] != $_SESSION['lid']){
    $view .= '<a href="tr_update_view.php?id='.h($r["id"]).'">';
    $view .= h($r["id"])." | ".h($r["name"])." | ".h($r["route"])." | ".h($r["departure"])." | ".h($r["arrival"])." | ".h($r["size"]);
    // $view .= $res['id'].', '.$res['name'].', '.$res['url'].', '.$res['comment'].', '.$res['datetime'];
    $view .= '</a><br>';
    }
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>マッチング結果表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
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
<div>
    <div class="container jumbotron"><?=$view?></div>
</div>
<!-- Main[End] -->

</body>
</html>
