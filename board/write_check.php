<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once("../main/db.php");
if (isset($_SESSION['id']) === false){
    header("Location: ../main/index.php");
    exit();
}

$tmpfile =  $_FILES['b_file']['tmp_name'];
$o_name = $_FILES['b_file']['name'];
$filename = iconv("UTF-8", "EUC-KR",$_FILES['b_file']['name']);
$folder = "./upload/".$filename;
move_uploaded_file($tmpfile,$folder);

$id = $_SESSION['id'];
$nameArray = db_select("select name from user_table where id = ?", array($id));
$name = $nameArray[0]['name'];
$date = date('Y-m-d');
$post_id = db_insert("insert into board (user_id, user_name, title, content, date, file) values (:user_id, :user_name, :title, :content, :date, :file)", 
    array(
        'user_id'=> $id,
        'user_name'=> $name,
        'title' => $_POST['title'],
        'content'=> $_POST['content'],
        'date'=> $date,
        'file'=> $o_name
    )
);
echo "<script>alert('게시글이 작성되었습니다.');</script>";
        echo "<meta http-equiv='refresh' content='0; url=list.php' />";
exit();
?>