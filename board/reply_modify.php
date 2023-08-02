<?php
require_once("../main/db.php");
session_start();
if (isset($_SESSION['id']) === false){
    header("Location: ../main/index.php");
    exit();
}

$r_id = $_SESSION['id'];
$r_seq = $_GET['seq'];
$con_num = $_GET['con_num'];
$date = date('Y-m-d');

// Form이 제출된 경우
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $check = db_select("select * from reply where id = :id and seq = :seq",
    array(
        'id' => $r_id,
        'seq' => $r_seq
        )
    );

    if($r_seq && $_POST['content'] && $r_id && !empty($check)) {
        $sql = db_update_delete("UPDATE reply SET content = :content, date = :date WHERE seq = :r_seq", 
        array(
            'content'=> $_POST['content'],
            'date' => $date,
            'r_seq' => $r_seq
            )
        );
        echo "<script>alert('댓글이 수정되었습니다.');</script>";
    }
    else
    {
        echo "<script>alert('수정에 실패했습니다.');</script>";
    }
    echo "<meta http-equiv='refresh' content='0; url=read.php?seq=$con_num' />";
    exit();
}

// 페이지가 처음 로드될 경우 (Form 제출 전)
$reply = db_select("select * from reply where seq = :seq",
    array(
        'seq' => $r_seq
    )
)[0];
?>

<!DOCTYPE html>
<head><title>댓글 수정</title></head>
<body>
    <div>
        <form method="post" action="">
            <input type="hidden" name="r_no" value="<?php echo $reply['seq']; ?>" />
            <textarea name="content"><?php echo $reply['content']; ?></textarea>
            <input type="submit" value="수정하기">
        </form>
    </div>
</body>
</html>
