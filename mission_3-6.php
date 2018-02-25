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
$form=$name."さんのIDです(/・ω・)/→→".$id;



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
 <link rel="stylesheet" href="stylesheet3-6.css">
 <title>3-6課題</title>
</head>
<body>

        <form action="" method="post">
         <h1>新規登録</h1>
         <h3>名前</h3>
         <input class="name" type="text" name="name" ></h3>
         <h3>パスワード</h3>
         <input class="pass" type="password" name="new_pass"required pattern="^(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)(?=.*?[$&,-._])[a-zA-Z\d$&,-._]{8,32}$">
         <p>※パスワード入力の注意事項※</p>
         <p>半角英数記号 8桁～32桁</p>
         <p>半角英数大文字、小文字、数字及び記号をそれぞれ一文字以上入力してください。</p>
         <p>【お使い頂ける記号】$ & , - . _ </p>
         <p></p>
         <p><input class="submit" type="submit" value="登録"></p>
         <p><?php echo $welcome;?></p>
         <p><?php echo htmlspecialchars($form);?></p>
         <a href="http://co-729.it.99sv-coco.com/mission_3-7.php">ログイン画面へ</a> 
        </form>


</body>
</html>

