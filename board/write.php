<?php
require_once("../main/db.php");
require_once("../main/header.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['id']) === false){
    header("Location: list.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>글 쓰기</title>
</head>
<body>
    <h2><a href="list.php">목록</a></h2>
    <h4>글을 작성하세요.</h4>
    <form action="write_check.php" method="post" enctype="multipart/form-data">
        <label>제목</label><br>
        <textarea name="title" placeholder="제목" rows="1" cols="80" maxlength="100" required></textarea><br>
        <label>내용</label><br>
        <textarea name="content" placeholder="내용을 입력하세요." rows="10" cols="80" required></textarea><br>
        <input type="file" value="1" name="b_file"><br>
        <input type="submit" value="작성">
    </form>
</body>
</html>