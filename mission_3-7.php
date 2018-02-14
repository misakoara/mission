
<?php
//====================================================================================================================
//ブラウザ画面
//=====================================================================================================================
?>
<!DOCTYPE html>
<html lang="ja">
<head>
 <meta charset="UTF-8">
 <meta name="robots" content="noindex, nofollow"/>
</head>
<body>

        <form action="" method="post">
         ログイン画面
         <p>ID:<input type="text" name="log_id" ></p>
         <p>パスワード:<input type="password" name="log_pass"></p>
         <p><input type="submit" value="ログイン"></p>
        </form>


</body>
</html>

<?php
//===============================================================================================//
//データベース接続
//===============================================================================================//
$dsn='データベース名';
$user='ユーザー名';
$password='パスワード';

try{
$pdo=new PDO($dsn,$user,$password);


//===============================================================================================//
//プログラム組み立て
//===============================================================================================//
if($_SERVER["REQUEST_METHOD"]==="POST"){//if1


//------------------------------------------------------
//入力フォーム
//------------------------------------------------------
  if(!empty($_POST["log_id"])&&!empty($_POST["log_pass"])){//if2

    $log_id=$_POST["log_id"];
    $log_pass=$_POST["log_pass"];


//データ検索
$sql="SELECT * FROM userdata WHERE id='$log_id'";

$result=$pdo->query($sql);

foreach($result as $row){

//登録したパスワードが一致したら、{}内の動作をする
if($row['pass']==$log_pass){//if☆

//セッションスタート
session_start();

//3-8の掲示板へ「name」を渡す
$_SESSION['name']=$row['name'];
//（検証）echo $_SESSION['name'];結果→成功：格納されている名前が表示

//3-8の掲示板へ移動する
header('Location: http://co-729.it.99sv-coco.com/mission_3-8.php');
exit;


}//if☆閉じ
else{
echo "一致しません";
}


}//foreach閉じ



  }//if２閉じ
}//if１閉じ
}//try閉じ
catch(PDOException $e){
   print('エラーが発生しました。'.$e->getMessage());
   die();
}

?>


