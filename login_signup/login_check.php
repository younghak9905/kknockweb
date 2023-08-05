<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once("../main/db.php");

$id = isset($_POST['id']) ? $_POST['id'] : null;
$pw = isset($_POST['pw']) ? $_POST['pw'] : null;

// 파라미터 체크
if ($id == null || $pw == null){
    echo "<script type='text/javascript'>alert('아이디와 비밀번호를 입력하세요.'); 
    window.location.href='login.php';</script>";
    exit();
}

// 회원 데이터
$member_data = db_select("select * from user_table where id = ?", array($id));

// 회원 데이터가 없다면
if ($member_data == null || count($member_data) == 0){
    echo "<script type='text/javascript'>alert('회원 정보가 없습니다.'); 
    window.location.href='login.php';</script>";
    exit();
}

// 비밀번호 일치 여부 검증
$is_match_password = password_verify($pw, $member_data[0]['pw']);

// 비밀번호 불일치
if ($is_match_password === false){
    echo "<script type='text/javascript'>alert('비밀번호가 일치하지 않습니다.'); 
    window.location.href='login.php';</script>";
    exit();
}

$_SESSION['id'] = $member_data[0]['id'];

// 목록으로 이동
header('Location: ../main/_main.php');
?>
