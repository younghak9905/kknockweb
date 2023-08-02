<!DOCTYPE html>
<html>
<head>
    <title>로그인 페이지</title>
    <meta charset="utf-8">
</head>
<body>
    <?php require_once("../main/header.php"); ?>
    <form action="login_check.php" method="post">
        <h3>LOGIN</h3>
        <?php if (isset($_GET['error'])) {
            echo $_GET['error'];
        }?>
        <label>ID</label>
        <input type="text" name="id" placeholder="User ID"><br>

        <label>Password</label>
        <input type="password" name="pw" placeholder="Password"><br>

        <button type="submit">로그인</button>
        <a href="signup.php">회원 가입</a>
    </form>
</body>
</html>