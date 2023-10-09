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
// $sql = "SELECT * FROM transport_table;";
$sql = "SELECT * FROM transport_table WHERE lid=:lid;";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":lid", $_SESSION['lid'], PDO::PARAM_STR);
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
    echo(h($r["id"]));
    $view .= "<p>便ID：".$r["id"]."</p>";
    $sql2 = "SELECT * FROM transport_table WHERE mid=:mid;";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->bindValue(":mid", $r["id"], PDO::PARAM_INT);
    $status2 = $stmt2->execute();
    if($status2==false) {
      //SQLエラーの場合
      sql_error($stmt2);
    }else{
      while( $l = $stmt2->fetch(PDO::FETCH_ASSOC)){
        // echo(h($l["id"]));
        // $view .= '< href="tr_update_view.php?id='.h($r["id"]).'">';
        if ($l["life_flg"]) {
          $view .= h($l["id"])." | ".h($l["name"])." | ".h($l["route"])." | ".h($l["departure"])." | ".h($l["arrival"])." | ".h($l["size"])." ";
          $view .= "[マッチング済]<br>";
        } else {
          $view .= h($l["id"])." | ".h($l["name"])." | ".h($l["route"])." | ".h($l["departure"])." | ".h($l["arrival"])." | ".h($l["size"])." ";
          $view .= '<a href="matching_update.php?id='.h($r["id"]).'&mid='.h($l["id"]).'"> ';
          $view .= "[受諾]</a> ";
          $view .= '<a href="matching_delete.php?id='.h($r["id"]).'&mid='.h($l["id"]).'"> ';
          $view .= "[拒否]</a><br>";
        }
      }
    }


    // if ($r["lid"] != $_SESSION['lid'] && !$r["life_flg"] && $r["id"] != $mid){
    //   // $view .= "<p>便IDは ".$r["id"]."</p>";
      // $view .= '<a href="tr_update_view.php?id='.h($r["id"]).'">';
      // $view .= h($r["id"])." | ".h($r["name"])." | ".h($r["route"])." | ".h($r["departure"])." | ".h($r["arrival"])." | ".h($r["size"]);
    //   // $view .= $res['id'].', '.$res['name'].', '.$res['url'].', '.$res['comment'].', '.$res['datetime'];
    //   $view .= '</a> ';
    //   $view .= '<a href="matching_insert.php?id='.$id.'&mid='.h($r["id"]).'"> ';
    //   $view .= "[マッチング申請]</a><br>";
    // }  
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
<?php include "header.html" ?>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <div class="container jumbotron"><?=$view?></div>
</div>
<!-- Main[End] -->

</body>
</html>
