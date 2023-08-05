<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once("../main/db.php");
if (isset($_SESSION['id']) === false){
    header("Location: ../main/_main.php");
    exit();
}

if (isset($_FILES['b_file']) && $_FILES['b_file']['error'] === UPLOAD_ERR_OK) {
    $tmpfile =  $_FILES['b_file']['tmp_name'];
    //$o_name = $_FILES['b_file']['name'];
    $filename = time().'-'.rand(1000,9999).'.'.pathinfo($_FILES['b_file']['name'], PATHINFO_EXTENSION);
    $folder = "./upload/".$filename;
    move_uploaded_file($tmpfile,$folder);
} else {
    $filename = null; 
}

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
        'file'=> $filename
    )
);

$seq = db_select("select * from board where seq = :seq",
array(
    'seq' => $seq
))[0];

echo "<script type='text/javascript'>alert('게시글이 작성되었습니다.');</script>";
echo "<meta http-equiv='refresh' content='0; url=list.php' />";

exit();
?>
