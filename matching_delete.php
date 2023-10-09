<?php
session_start();
//0. 関数群の読み込み
include("funcs.php");
sschk();

//1. POSTデータ取得
$id = $_GET['id'];
// $mid = $_GET['mid'];

//2. DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  $pdo = db_conn();      //DB接続関数
} catch (PDOException $e) {
  exit('DB Connection Error:'.$e->getMessage());
}

//３．データ登録SQL作成
// $stmt = $pdo->prepare("INSERT INTO gs_user_table(name,lid,lpw,kanri_flg,life_flg)VALUES(:name, :lid, :lpw, :kanri_flg, :life_flg);");
$sql = "UPDATE transport_table SET mid=:mid WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':mid', 0, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //実行

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  sql_error($stmt);
}else{
  //５．index.phpへリダイレクト
  redirect("matching_view.php?id=".$id);
}
?>
