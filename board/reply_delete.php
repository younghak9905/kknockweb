<?php
require_once("../main/db.php");
session_start();

if (isset($_SESSION['id']) === false){
    header("Location: ../main/index.php");
    exit();
}

$id = $_SESSION['id'];
$seq= $_GET['seq'];

//1. 댓글 작성자의 아이디와 현재 로그인한 사용자의 아이디 일치 여부 확인
//2. 댓글이 작성된 con_num에서 해당 댓글의 seq로 삭제

$check = db_select("select * from reply where id = :id and seq = :seq",
array(
    'id' => $id,
    'seq' => $seq
    )
);

if(!empty($check)){
    $del = db_update_delete("DELETE FROM reply WHERE id = :id AND seq = :seq", array(
        'id' => $id,
        'seq' => $seq
    ));
    echo "<script type='text/javascript'>alert('댓글이 삭제되었습니다!');</script>";
    echo "<meta http-equiv='refresh' content='0; url=list.php' />";
}

else {
    echo "<script type='text/javascript'>alert('댓글 삭제 권한이 없습니다.');</script>";
    echo "<meta http-equiv='refresh' content='0; url=list.php' />";
}
?>