<p style='text-align:right'>            
    <?php
    if (isset($_SESSION) === false){session_start();}

    if (isset($_SESSION['id']) === false){?>
    <a href="../main/index.php">홈</a>
    <a href="../login_signup/signup.php">회원가입</a>
    <a href="../login_signup/login.php">로그인</a>
    <?php
    }
    else{?>
    <a href="../main/index.php">메인</a>
    <a href="../login_signup/logout.php">로그아웃</a>
    <?php
    }
    ?>
</p>
