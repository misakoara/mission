<?php
//===============================================================================================//
//プログラム組み立て
//===============================================================================================//

if($_SERVER["REQUEST_METHOD"]==="POST"){
//------------------------------------------------------
//入力フォーム
//------------------------------------------------------
  if(!empty($_POST["name"])&&!empty($_POST["coment"])&&empty($_POST["edit_hidden"])&&!empty($_POST["pass"])){
    $name=$_POST["name"];
    $coment=$_POST["coment"];
    $time =date("Y年m月d日 H時i分s秒");
    $pass=$_POST["pass"];
//カウント作成
     $file_count=file('file_count2-6.txt');//カウント用ファイル定義
     $c=fopen('file_count2-6.txt',"a");//カウント用ファイルを追記保存モードで開く
    $count= count(file('file_count2-6.txt'))+1;//カウント用ファイルの要素を数え、それに＋１した数
     fwrite($c,$count."\r\n");//$count(要素数)を追記保存で書き込む
     fclose($c);
//動作（追記）
     $fp=fopen('kadai2-6.txt',"a");//課題ファイルを追記保存モードで開く
    $all=$count."<>".$name."<>".$coment."<>".$time."<>".$pass."<>";
     fwrite($fp,$all."\r\n");
     fclose($fp);
     //print $all;//☆確認→結果：パスワード付きで保存されていることを確認
  }
//------------------------------------------------------
//削除フォーム
//------------------------------------------------------
  else if(!empty($_POST["delete"])&&!empty($_POST["del_pass"])){
    $delete=$_POST["delete"];
    $del_pass=$_POST["del_pass"];
     //(検証)
    //echo $del_pass;//☆結果→入力したパスワード表示された。

     $file=file('kadai2-6.txt');//主テキストを読み込む
     $a=fopen('kadai2-6.txt',"w");
     //↑・・fopen・fwriteの操作が上手くいっておらず、削除番号を送るとすべて消えてしまうため、いったんコメントアウト。

     //読み込んだテキスト内に格納されている要素（行＄line）を読み込み｛｝内の処理を行う。
     foreach($file as $line){
       //$lineを＜＞で区切った要素を変数$delDataとする。
       $delData=explode("<>",$line);

            //（検証）
            //echo $delData[4];//結果→「four five」と表示される
            //echo $del_pass;//結果→「fivefive」と表示される
            //↑原因：下のif文内にないと、delData[4]は目的のパスワードが表示されない。$delData[4]==$del_passはできない。

  //if１：削除フォームで送られてきた番号と合致した行について以下の動作を指示する。
       if($delData[0]==$delete){//○if１

         //（検証）
         //echo $delData[4];//☆結果→「five」と表示される
         //echo $del_pass;//☆結果→「five」と表示される
           //echo "|".$delData[4]."|".$del_pass."|";//☆結果→「|pass |pass|」と表示された。delData[4]の後ろに半角スペースがあるようだ。なぜ？
           //echo "|".$delData[0]."|".$delete."|";//☆結果→「|5|5|」半角スペースは入ってなかった。
           //↑考察：問題は、delData[4]の半角スペース？
           //☆☆解決☆☆　入力フォームで格納するときに、$passの後ろにも"<>"を入れたところ解決。


    //if2：「$delData[4]・送信された番号の行の5番目に格納してあるpassデータ」と「$del_pass・削除フォーム下のパス欄から送信されたpassデータ」が等しい時、以下の動作をする。
          if(!($delData[4]==$del_pass)){//△if2

            //（検証）
            //echo "a";//☆aと表示された

          $delete_passErr="パスワードが一致しません";

            fwrite($a,$line."\r\n");//☆削除したい番号の$lineを開いた主テキストへ上書保存する。→結果：テキストファイル内のすべてのデータが消えてしまった。
          
          }//△if2閉じ
          
       }//○if１閉じ

  //else１:送信された番号以外の行について、再度上書き保存する。
       else {//○else１

            //(検証)
            //echo "c";//☆結果→cが該当番号以外の行数分、表示された。foreach内だから。
            //$all_delete=$delData[0]."<>".$delData[1]."<>".$delData[2]."<>".$delData[3]."<>".$delData[4]."<>";
            fwrite($a,$line."\r\n");//☆削除したい番号の$lineを開いた主テキストへ上書保存する。→結果：テキストファイル内のすべてのデータが消えてしまった。
             //↑・・fopen・fwriteの操作が上手くいっておらず、削除番号を送るとすべて消えてしまうため、いったんコメントアウト。

        }//○else１閉じ

     }//foreach閉じ

       fclose($a);

     $delete="";//テキストボックスを空にする
     $del_pass="";//テキストボックスを空にする

  }//削除プログラム終了

//-----------------------------------------------------------
//編集フォーム１☆該当番号をテキストボックスへ送る
//-----------------------------------------------------------
  else if(!empty($_POST["edit"])&&!empty($_POST["edit_pass"])){
   $edit=$_POST["edit"];
   $edit_pass=$_POST["edit_pass"];

  $file=file('kadai2-6.txt');
    foreach($file as $line){

      $editData=explode("<>",$line);

   //if①編集テキストに送信された番号と一致した時
    if($editData[0]==$edit){
       if($editData[4]==$edit_pass){
      //該当する番号の「名前」「コメント」をテキストボックスへ送る
       $name_edit=$editData[1];
       $coment_edit=$editData[2];
        }
       else{
         $edit_passErr="パスワードが一致しません。";
          }
          
     }//☆if①

    }
      //hiddenへ値を送る☆hidden→textへ変えることで、”編集中だよ”及び”編集中”へ値が入っていることを確認なう。
       $edit_hidden=$edit;
       //echo $edit_hidden;
}//編集自体の動作閉じ→→→編集終了。


//---------------------------------------------------------------------
//編集作業２
//--------------------------------------------------------------------
//置き換えるプログラム
   else if(!empty($_POST["name"])&&!empty($_POST["coment"])&&!empty($_POST["edit_hidden"])){
      $edit_hidden=$_POST["edit_hidden"];
        $file=file('kadai2-6.txt');
        $e=fopen('kadai2-6.txt',"w");
         foreach($file as $line){
          $editData2=explode("<>",$line);

   //if②-2　変数edit（投稿された編集番号）と一致した番号の配列一行に以下の動作を行う。
          if($editData2[0]==$edit_hidden){
        //編集前からの番号・新たに送信された（編集された）名前・新たに送信された（編集された）コメント・元の投稿時間をテキストへ上書する。
            $edit_data=$editData2[0]."<>".$_POST["name"]."<>".$_POST["coment"]."<>".$editData2[3]."<>".$editData2[4]."<>";
            fwrite($e,$edit_data."\r\n");
       }//ifの閉じ

        //該当編集番号以外の配列を再上書保存。
     else{
       $all=$editData2[0]."<>".$editData2[1]."<>".$editData2[2]."<>".$editData2[3]."<>".$editData2[4]."<>";
       fwrite($e,$all."\r\n");
       }

     }//foreachの閉じ
     fclose($e);
     $edit_hidden="";
   }//置き換えるプログラム閉じ


//------------------------------------------------------------
//入力フォームエラー
//------------------------------------------------------------

 else{
     $name=$_POST["name"];
     $coment=$_POST["coment"];
     $pass=$_POST["pass"];
     $err="投稿内容が不十分です。";
    }
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
         <p>名前</p>
         <p><input type="text" name="name" value=<?php echo $name_edit;?>></p>
         <p>コメント</p>
         <p><input type="text" name="coment" value=<?php echo $coment_edit;?>></p>
         <p><input type="hidden" name="edit_hidden" value=<?php echo $edit_hidden;?>></p>
         <p>パスワード作成</p>
         <p><input type="password" name="pass"></p>
         <p style="color:red;"><?php echo $err;?></p>
         <p><input type="submit" value="投稿"></p>
        </form>

        <form action="" method="post">
         <p>削除対象番号</p>
         <p><input type="text" name="delete" value="<?php echo htmlspecialchars($delete, ENT_QUOTES, "UTF-8"); ?>"></p>
         <p>パスワード</p>
         <p><input type="password" name="del_pass"></p>
         <p style="color:red;"><?php echo $delete_passErr;?></p>
         <p><input type="submit" value="削除"></p>
        </form>

        <form action="" method="post">
         <p>編集対象番号</p>
         <p><input type="text" name="edit" value="<?php echo htmlspecialchars($edit, ENT_QUOTES, "UTF-8"); ?>"></p>        
         <p>パスワード</p>
         <p><input type="password" name="edit_pass"></p>
         <p style="color:red;"><?php echo $edit_passErr;?></p>
         <p><input type="submit" value="編集"></p>
        </form>
        
</body>
</html>

<hr>
<?php
//================================================================
//フォーム下にて　保存された値を表示
//================================================================ 
$file=file('kadai2-6.txt');
  foreach($file as $line){
   $data=explode("<>",$line);
   echo"<p>";
   echo $data[0]." ".$data[1]." ".$data[2]." ".$data[3]." ".$data[4];
   echo "</p>";
   
  }
?>