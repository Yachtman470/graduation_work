<?php
session_start();
//0. 関数群の読み込み
include("funcs.php");
sschk();

//1. POSTデータ取得

$id = $_GET['id'];
$mid = $_GET['mid'];


//2. DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  $pdo = db_conn();      //DB接続関数
} catch (PDOException $e) {
  exit('DB Connection Error:'.$e->getMessage());
}

//３．データ登録SQL作成
$sql = "UPDATE transport_table SET mid=:mid, life_flg=:life_flg WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $id, PDO::PARAM_INT);
$stmt->bindValue(":mid", $mid, PDO::PARAM_INT);
$stmt->bindValue(":life_flg", 1, PDO::PARAM_INT);
$status = $stmt->execute(); //実行

$sql = "UPDATE transport_table SET life_flg=:life_flg WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $mid, PDO::PARAM_INT);
// $stmt->bindValue(":mid", $id, PDO::PARAM_INT);
$stmt->bindValue(":life_flg", 1, PDO::PARAM_INT);
$status = $stmt->execute(); //実行

//４．データ登録処理後
if($status==false){
  sql_error($stmt);
}else{
  redirect("matching_result_view.php");
}

?>
