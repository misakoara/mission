<?php
//----------------------------------------------------------------------
//データベース情報
//----------------------------------------------------------------------
$dsn='データベース名';
$user='ユーザー名';
$password='パスワード';

try{//☆データベース接続
//-----------------------------------------------------------------------
//データベース接続
//------------------------------------------------------------------------
$pdo=new PDO($dsn,$user,$password);

session_start();

//＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
//　　　　　　　　　　　　　　　　　プログラム
//＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝

if($_SERVER["REQUEST_METHOD"]==="POST"){
//=====================================================
//                  入力フォーム
//=====================================================
  if(!empty($_POST["name"])&&!empty($_POST["comment"])){
    $name=$_POST["name"];
    $comment=$_POST["comment"];
    $time =date("Y-m-d H:i:s");

//動作（追記）
//-----------------------------
//データ挿入
//-----------------------------
$sql="INSERT INTO easy_board(id,name,comment,day)VALUES('','$name','$comment','$time')";
$result=$pdo->query($sql);


}//☆データ挿入if閉じ

}//☆POST閉じ
}//☆データベース接続try閉じ
//-------------------------------
//接続エラー
//-------------------------------
catch(PDOException $e){
   print('エラーが発生しました。'.$e->getMessage());
   die();
}
?>

<?php
///＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
//                                         ブラウザ画面　
///＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
?>
<!DOCTYPE html>
<html lang="ja">
<head>
 <meta charset="UTF-8">
 <meta name="robots" content="noindex, nofollow"/>
 <link rel="stylesheet" href="stylesheet3-8.css">
 <title>3-8課題</title>
</head>
<body>
  <div class="form">
        <form action="" method="post" enctype="multipart/form-data">
      <h1>☆簡易掲示板☆</h1>
         <h3>名前</h3>
         <p><input type="text" name="name" class="name" value=<?php echo htmlspecialchars($_SESSION['name']);?>></p>
         <h3>コメント</h3>
         <p><textarea name="comment" class="comment"></textarea></p>
         <p><input class="submit" type="submit" value="投稿"></p>
        </form>
  </div>

<hr class="style-board">
<div class="board">
<?php
///====================================================================================================
//　　　　　　　　　　　　                 投稿内容表示
///=====================================================================================================

try{
//---------------------
//データベース接続
//---------------------
$pdo=new PDO($dsn,$user,$password);

  //データ件数の取得
     $sql_a='SELECT * FROM easy_board';
     $result_a=$pdo->query($sql_a);
       $row_count = $result_a->rowCount();//○カウント
       echo "投稿件数".":".$row_count."件".'<br>'.'<br>';//○画面上の表示

//=====================================================
//                    ページング処理
//=====================================================

    //ページの受け渡しのための変数
      $page = $_GET['page'];
        //☆☆☆GETはURLに直接付加する☆☆☆→→POSTではpageを受け取れなかったのは、GETと送り方が違うから。
      //echo $page;//☆確認

       //～$pageに値がない場合～
         if ($page == "" ) {
           $page = 1;
          }

       //～$pageが１より小さい場合は１
         $page = max($page, 1);


      //最終ページ取得
        $maxPage = ceil($row_count / 10 );//最後のページ番号判明
          //echo $maxPage;//☆確認

      //現在のページ確認
        $page = min($page, $maxPage);
          //echo $page;
      //オフセットの値を指定→→1ページ目なら1から。2ページ目なら11から表示させる準備。
         $start = ($page - 1) * 10;
        //echo $start;

      //表示件数10件ずつデータ取得
         $sql='SELECT * FROM easy_board LIMIT '.$start.',10';
          //☆LIMIT (オフセット開始番号),最大表示件数☆

$result=$pdo->query($sql);

foreach($result as $row){
echo '<span class="id">'.$row['id'].'</span>';
echo ':'.'<span class="name">'.htmlspecialchars($row['name']).'</span>';
echo '<span class="day">'.$row['day'].'</span>';
echo '<div class="comment_board">'.htmlspecialchars($row['comment']).'</div>'.'<hr>';
}//foreach閉じ



}//try閉じ
//-------------------------------
//接続エラー
//-------------------------------
catch(PDOException $e){
   print('エラーが発生しました。'.$e->getMessage());
   die();
}
?>

</div>



<?php
//===========================
//前へ次へ
//============================

//--------------------------------------------
//最小ページ数（１）でない時の「前ページ機能」
//--------------------------------------------
if($page > 1 ) {?>

<a href="mission_3-8.php?page=<?php print($page - 1); ?>">前のページ</a>

<?php

}else{
?>

 前のページ 

<?php
}
//---------------------------------------------
//最大ページ数（max）でない時の「次ページ機能」
//---------------------------------------------
if ($page < $maxPage ){
?>
　　
<a href="mission_3-8.php?page=<?php print($page + 1); ?>">次のページ</a>

<?php
if(isset($page)){
$page=$page+1;
}
 }
else{
?>

次のページ

<?php
}//else閉じ
?>

</body>
</html>



<?php
//メモ
//<h3>アップロード</h3>
//<p><input type="file" name="fname"></p>
//echo $row['content'].'<hr>'
/*if(empty($_FILES['fname']['name'])){

//(検証)echo "a";→表示された


}

※※※アップロード未完成なため、コメントアウトします。※※※
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


}

//---mimeタイプによる分岐②動画---
 elseif($fname_mime['extension']='mp4'){

  }

}//☆elseif閉じ
*/
?>
