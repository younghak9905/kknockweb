<?php
require_once("../main/db.php");

$id = isset($_POST['id']) ? $_POST['id'] : null;
$pw = isset($_POST['pw']) ? $_POST['pw'] : null;
$pw_check = isset($_POST['pw_check']) ? $_POST['pw_check'] : null;
$name = isset($_POST['name']) ? $_POST['name'] : null;

if ($id == null || $pw == null || $name == null || $pw_check == null){
    echo "<script type='text/javascript'>alert('모든 정보를 입력하세요.'); 
    window.location.href='signup.php';</script>";
    exit();
}

$member = db_select("select count(id) seq from user_table where id = ?", array($id));
if ($member && $member[0]['seq'] == 1){
    echo "<script type='text/javascript'>alert('이미 사용중인 아이디입니다.');
        window.location.href='signup.php';</script>";
    exit();
}

if ($pw != $pw_check) {
    echo "<script type='text/javascript'>alert('비밀번호가 일치하지 않습니다.');        
    window.location.href='signup.php';</script>";
    exit();
}
//암호화
$bcrypt_pw = password_hash($pw, PASSWORD_BCRYPT);

//저장
$result = db_insert("insert into user_table (id, name, pw) values (:id, :name, :pw)",
    array(
        'id' => $id,
        'name' => $name,
        'pw' => $bcrypt_pw
    )
);

if ($result === false) {
    echo "<script type='text/javascript'>alert('회원가입에 실패했습니다!'); 
    window.location.href='signup.php';</script>";
} else {
    echo "<script type='text/javascript'>alert('회원가입이 완료되었습니다! 반환값: {$result}'); 
    window.location.href='login.php';</script>";
}

exit();
?>
