<?php

$dsn='データベース名';
$user='ユーザー名';
$password='パスワード';

try{
    $dbh=new PDO($dsn,$user,$password);
    print('接続に成功しました。<br>');

    $pdo=null;
}

catch(PDOException $e){
   print('エラーが発生しました。:'.$e->getMessage());
   die();
}
?>
     