<!DOCTYPE html>
<html lag ="ja">
    <head>
    <meta charset="utf-8">
    <title>mission5-1</title>
    </head>
    <body>
    <font size="5"><strong>夏休みしたいことベスト１</strong></font>
    <font size="3">例 旅行いきたい！！</font><br><br>
<?php
    
	$dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
	$sql = "CREATE TABLE IF NOT EXISTS KEIJIBAN"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name char(32),"
	. "comment TEXT,"
	. "registry_datetime DATETIME,"
	. "pass varchar(255)"
	.");";
	
	$stmt = $pdo->query($sql);
//投稿開始

if(isset($_POST["names"]) && $_POST["names"] !="" && isset($_POST["comments"]) && $_POST["comments"] !=""&&isset($_POST["pass"]) && $_POST["pass"] !="" )
{
 if($_POST["bango"] =="")
 {   
	$sql = $pdo -> prepare("INSERT INTO KEIJIBAN (name, comment,registry_datetime,pass) VALUES (:name, :comment,:registry_datetime,:pass)");
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	$sql -> bindParam(':registry_datetime', $registry_datetime, PDO::PARAM_STR);
	$sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
	$name = $_POST["names"];
	$comment = $_POST["comments"];
	$registry_datetime = date("Y/m/d H:i:s");
	$pass = $_POST["pass"];
	$sql -> execute();
	
  }
  elseif(isset($_POST["bango"]) && $_POST["bango"] !="" )
  {
 	$id = $_POST["bango"]; //変更する投稿番号
	$name = $_POST["names"];
	$comment = $_POST["comments"];//変更したい名前、変更したいコメントは自分で決めること
	$registry_datetime = date("Y/m/d H:i:s");
	$sql = 'UPDATE KEIJIBAN SET name=:name,comment=:comment,registry_datetime=:registry_datetime WHERE id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	$stmt->bindParam(':registry_datetime', $registry_datetime, PDO::PARAM_STR);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
  }
}
//投稿終了

//削除処理開始
if(isset($_POST["delete"]) && $_POST["delete"] !="" && isset($_POST["pass_del"])&& $_POST["pass_del"] !="")
{
    $sql = 'SELECT * FROM KEIJIBAN';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row)
	{
	    
	  if($_POST["delete"] == $row['id'] && $_POST["pass_del"] == $row['pass'])
	  {
      $id = $_POST["delete"];
	  $sql = 'delete from KEIJIBAN where id=:id';
	  $stmt = $pdo->prepare($sql);
	  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	  $stmt->execute();
      }
      elseif($_POST["delete"]  == $row['id'] && $_POST["pass_del"] != $row['pass'])
      {
       echo"パスワードが間違ってます";
      }
        
    }
}
//削除処理終了


//編集表示開始
if(isset($_POST["edit"]) && $_POST["edit"] != "" && isset($_POST["pass_edit"]) && $_POST["pass_edit"] !="")
{
    $edit=$_POST["edit"];
    $sql = 'SELECT * FROM KEIJIBAN';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row)
	{
	   if($edit == $row['id']  && $_POST["pass_edit"] ==$row['pass'])
       {
       $editnum=$row['id'];
       $editname=$row['name'] ;
       $editcomment=$row['comment'];
     
	   }
	   elseif($edit == $row['id']  && $_POST["pass_edit"] !=$row['pass'])
       {
       echo"パスワードが間違ってます";
       }
    
    } 

}

//編集表示終了

//編集処理開始
//編集処理終了
?>

    <form action="" method="post">
    
    <form action="" method="post">
    <form action="" method="post">
    <input type="text" name="names" value="
    <?php 
    if(isset($editname)&&$editname!=""){
    echo $editname;
    }
    ?>"placeholder="名前" > <br>
    <input type="text" name="comments"value="
    <?php 
    if(isset($editcomment)&&$editcomment!=""){
    echo $editcomment;
    }
    ?>" placeholder="コメント" ><br>
    <input type="password" name="pass"value="" placeholder="パスワード">
    <input type="submit" name="submit"><br>
    <input type="hidden" name="bango"value="<?php echo $editnum;?>"><br>
    <input type="number" name="delete"value="" placeholder="削除対象番号"><br>
    <input type="password" name="pass_del"value="" placeholder="パスワード">
    <input type="submit" value="削除"><br><br>
    <input type="number" name="edit"value="" placeholder="編集対象番号"><br>
    <input type="password" name="pass_edit"value="" placeholder="パスワード">
    <input type="submit" value="編集"><br><br>
    
    <!--　フォームのhtml -->
    

<?php

//表示開始
	$sql = 'SELECT * FROM KEIJIBAN';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row)
	{
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].'<>';
		echo $row['name'].'<>';
		echo $row['comment'].'<>';
		echo $row['registry_datetime']. '<br>';
	echo "<hr>";
	}
