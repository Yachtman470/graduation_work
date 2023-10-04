<?php
//最初にSESSIONを開始！！ココ大事！！
session_start();

//POST値
//POST値
$lid = $_POST["lid"];
$lpw = $_POST["lpw"];

//1.  DB接続します
include("funcs.php");
$pdo = db_conn();

//2. データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_user_table WHERE lid = :lid"); // lidだけに変更
$stmt->bindValue(':lid',$lid, PDO::PARAM_STR);
// $stmt->bindValue(':lpw',$lpw, PDO::PARAM_STR); コメントアウト
$status = $stmt->execute();
//3. SQL実行時にエラーがある場合STOP
if($status==false){
    sql_error($stmt);
}

//4. 抽出データ数を取得
$val = $stmt->fetch();         //1レコードだけ取得する方法
//$count = $stmt->fetchColumn(); //SELECT COUNT(*)で使用可能()

//5. 該当レコードがあればSESSIONに値を代入
$pw = password_verify($lpw, $val["lpw"]);
if( $pw ){
  //Login成功時
  $_SESSION['chk_ssid']  = session_id();
  $_SESSION['kanri_flg'] = $val['kanri_flg'];
  $_SESSION['name']      = $val['name'];
  redirect('tr_list_view.php');
}else{
  //Login失敗時(Logout経由)
  redirect('login.php');
}
  
exit();

