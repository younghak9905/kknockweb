<!DOCTYPE html>
<html>
<head>
    <title>회원가입 페이지</title>
</head>
<body>
    <?php require_once("../main/header.php"); ?>
    <form action="signup_check.php" method="POST">
    <h3>회원가입</h3>
    <?php if (isset($_GET['error'])) {
            echo $_GET['error'];
        }?>
    <?php if (isset($_GET['success'])) {
            echo $_GET['success'];
        }?>
    
    <label>Name</label>
    <input type="text" name="name" placeholder="name"><br>
    
    <label>ID</label>
    <input type="text" name="id" placeholder="User ID"><br>

    <label>Password</label>
    <input type="password" name="pw" placeholder="Password"><br>

    <label>Password Check</label>
    <input type="password" name="pw_check" placeholder="Password_check"><br>

    <input type="submit" value="회원가입">
    </form>
</body>
</html>