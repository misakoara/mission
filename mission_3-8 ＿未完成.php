<?php
//=======================================================================================
//データベース
//========================================================================================
$dsn='データベース名';
$user='ユーザー名';
$password='パスワード';

try{//☆データベース接続
//--------------------------------------------------------------------------
//データベース接続
//---------------------------------------------------------------------------
$pdo=new PDO($dsn,$user,$password);
//print "接続完了しました";

session_start();

//===============================================================================================//
//プログラム組み立て
//===============================================================================================//

if($_SERVER["REQUEST_METHOD"]==="POST"){
//----------------------------------------------------------------------------------------------
//入力フォーム
//---------------------------------------------------------------------------------------------
  if(!empty($_POST["name"])&&!empty($_POST["comment"])){
    $name=$_POST["name"];
    $comment=$_POST["comment"];
    $time =date("Y/m/d H:i:s");




//動作（追記）
//-----------------------------
//データ挿入
//-----------------------------
if(empty($_FILES['fname']['name'])){

//(検証)echo "a";→表示された
$sql="INSERT INTO upData(id,name,comment,day)VALUES('','$name','$comment','$time')";
$result=$pdo->query($sql);

}

elseif(!empty($_FILES['fname']['name'])){
echo "b"."<br>";
echo $_FILES['fname']['name']."<br>";
echo $_FILES['fname']['type']."<br>";
echo $_FILES['fname']['tmp_name']."<br>";
echo $_FILES['fname']['error']."<br>";
echo $_FILES['fname']['size']."<br>";

//分岐のための変数（mimeタイプ）
$fname_mime=$_FILES['fname'];
echo $fname_mime['extension'];

//---mimeタイプによる分岐①画像---
 if($fname_mime['extension']='jpg'){

echo "c";

}

//---mimeタイプによる分岐②動画---
 elseif($fname_mime['extension']='mp4'){
  echo "d";
  }

}//☆elseif閉じ






/*============<memo>==================================================
<?php
$file=pathinfo("http://test/test.php");
echo $file["dirname"]."<br>";
echo $file["basename"]."<br>";
echo $file["extension"]."<br>";
?>
/*$ext = substr($fname, strrpos($fname, '.') + 1);
if(header('Content-Type: image/png')){
        //header('Content-Type: image/png');
$sql="INSERT INTO upData(id,name,comment,content,day)VALUES('','$name','$comment','$fname','$time')";
$result=$pdo->query($sql);
        //readfile($fname);
}*/==========================================================================


}//☆データ挿入if閉じ

}//☆POST閉じ
}//☆データベース接続try閉じ
//------------------------------------------------------------------------
//接続エラー
//----------------------------------------------------------------------
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

        <form action="" method="post" enctype="multipart/form-data">
         <p>名前</p>
         <p><input type="text" name="name" value=<?php echo $_SESSION['name'];?>></p>
         <p>コメント</p>
         <p><input type="text" name="comment" ></p>
         <p>アップロード</p>
         <p><input type="file" name="fname"></p>
         <p style="color:red;"><?php echo $err;?></p>
         <p><input type="submit" value="投稿"></p>
        </form>

</body>
</html>


<hr>
<?php
//=======================================================================
//データ表示
//======================================================================
//
//データベースの情報
//
$dsn='mysql:dbname=co_729_it_3919_com;host=localhost';
$user='co-729.it.3919.c';
$password='CR67VUe';

try{
//
//データベース接続
//
$pdo=new PDO($dsn,$user,$password);
//echo "a";
//
//テーブルデータの表示
//
$sql='SELECT * FROM upData';

$result=$pdo->query($sql);

//echo "b";

foreach($result as $row){
echo $row['id'];
echo $row['name'].'<br>';
echo $row['comment'].'<br>';
echo $row['content'];
echo $row['day'].'<br>'.'<br>';
}//foreach閉じ

}//try閉じ
//================================================================
//接続エラー
//==================================================================
catch(PDOException $e){
   print('エラーが発生しました。'.$e->getMessage());
   die();
}
?>