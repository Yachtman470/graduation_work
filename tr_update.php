<?php
session_start();
//0. 関数群の読み込み
include("funcs.php");
sschk();

//1. POSTデータ取得
$name = $_POST['name'];
$route = $_POST['route'];
$departure = $_POST['departure'];
$arrival = $_POST['arrival'];
$size = $_POST['size'];
$id    = $_POST["id"];   //idを取得

//2. DB接続します
$pdo = db_conn();      //DB接続関数


//３．データ登録SQL作成
$sql = "UPDATE transport_table SET name=:name, route=:route, departure=:departure, arrival=:arrival, size=:size WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':route', $route, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':departure', $departure, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':arrival', $arrival, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':size', $size, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':id',$id,  PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //実行


//４．データ登録処理後
if($status==false){
    sql_error($stmt);
}else{
    redirect("tr_list_view.php");
}

?>
