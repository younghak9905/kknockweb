<!DOCTYPE html>
<html>
<head>
    <title>KKNOCK WEB - 14기 강민지</title>
    <meta charset="utf-8">
</head>
<body>
    <?php require_once("header.php"); 
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['id'])){
        echo "<h2>게시판 메인 페이지</h2>";
        echo "<h4>{$_SESSION['id']}님 안녕하세요.</h4>";
        echo "<label><a href='../board/list.php'>목록</a></label>";
    }
    else {
        echo "<h3>Hallo! Freut mich, Sie konnenzulernen.<h3>";
    }
    ?>
</body>
</html>
