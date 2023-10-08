<?php
session_start();
//0. 関数群の読み込み
include("funcs.php");
sschk();

//1. POSTデータ取得
//$name = filter_input( INPUT_GET, ","name" ); //こういうのもあるよ
//$email = filter_input( INPUT_POST, "email" ); //こういうのもあるよ
$id = $_GET['id'];
$mid = $_GET['mid'];
// $departure = $_POST['departure'];
// $arrival = $_POST['arrival'];
// $size = $_POST['size'];

//2. DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  $pdo = db_conn();      //DB接続関数
} catch (PDOException $e) {
  exit('DB Connection Error:'.$e->getMessage());
}

//３．データ登録SQL作成
$sql = "UPDATE transport_table SET mid=:mid WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':mid', $mid, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
// $stmt->bindValue(':departure', $departure, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
// $stmt->bindValue(':arrival', $arrival, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
// $stmt->bindValue(':size', $size, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
// $stmt->bindValue(':id',$id,  PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //実行

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  sql_error($stmt);
}else{
  //５．index.phpへリダイレクト
  // $rd = "matching_view.php?id=".$id;
  // redirect($rd);
  redirect("matching_view.php?id=".$id);
  // $view .= '<a href="tr_delete.php?id='.h($r["id"]).'"> ';
}
?>
