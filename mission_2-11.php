<?php
//=======================================================================================
//データベースの情報
//========================================================================================
$dsn='データベース名';
$user='ユーザー名';
$password='パスワード';

try{
//========================================================================================
//データベース接続
//=========================================================================================
$pdo=new PDO($dsn,$user,$password);
print "接続完了しました";

//==========================================================================================
//データ挿入
//============================================================================================
$sql="INSERT INTO nameData(ID,NAME,COMMENT)VALUES('','みさき','です')";

$result=$pdo->query($sql);
}
//================================================================
//接続エラー
//==================================================================
catch(PDOException $e){
   print('エラーが発生しました。'.$e->getMessage());
   die();
}
?>
    