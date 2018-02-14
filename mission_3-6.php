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
if($_SERVER["REQUEST_METHOD"]==="POST"){


//------------------------------------------------------
//新規登録
//------------------------------------------------------
  if(!empty($_POST["name"])&&!empty($_POST["new_pass"])){

    $name=$_POST["name"];
    $new_pass=$_POST["new_pass"];
    

//IDの生成
$id=uniqid();

//echo $new_pass;
$sql="INSERT INTO userdata(id,name,pass)VALUES('$id','$name','$new_pass')";
$result=$pdo->query($sql);

$welcome="新規登録完了しました！";
$form=$name."さんのIDです(/・ω・)/"."<br>".$id;



}
}
}
catch(PDOException $e){
   print('エラーが発生しました。'.$e->getMessage());
   die();
}

?>
 
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
         新規会員登録はこちら♪
         <p>ニックネーム:<input type="text" name="name" ></p>
         <p>パスワード:<input type="password" name="new_pass"></p>
         <p><input type="submit" value="登録"></p>
         <p><?php echo $welcome;?></p>
         <p><?php echo $form;?></p>
        </form>


</body>
</html>

