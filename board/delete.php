<?php
require_once("../main/db.php");
require_once("../main/header.php"); 
session_start();

if (isset($_SESSION['id']) === false){
    header("Location: ../main/_main.php");
    exit();
}

$id = $_SESSION['id'];
$seq = $_GET['seq'];

$check = db_select("select * from board where user_id = :user_id and seq = :seq",
array(
    'user_id' => $id,
    'seq' => $seq
    )
);

if(!empty($check)){
    $del = db_update_delete("DELETE FROM board WHERE user_id = :user_id AND seq = :seq", array(
        'user_id' => $id,
        'seq' => $seq
    ));
    echo "<script type='text/javascript'>alert('삭제되었습니다!');</script>";
    echo "<meta http-equiv='refresh' content='0; url=list.php' />";
}

else {
    echo "<script type='text/javascript'>alert('삭제 권한이 없습니다.');</script>";
    echo "<meta http-equiv='refresh' content='0; url=list.php' />";
}

?>