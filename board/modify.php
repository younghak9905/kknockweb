<?php
require_once("../main/db.php");
require_once("../main/header.php"); 
session_start();

if (isset($_SESSION['id']) === false){
    header("Location: ../main/index.php");
    exit();
}

$id = $_SESSION['id'];
$seq = $_GET['seq'];
$date = date('Y-m-d');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $check = db_select("select * from board where user_id = :user_id and seq = :seq",
    array(
        'user_id' => $id,
        'seq' => $seq
        )
    );

    if(!empty($check)){
        $edit = db_update_delete("UPDATE board SET content = :content, date = :date WHERE seq = :seq", 
        array(
            'content'=> $_POST['content'],
            'date' => $date,
            'seq' => $seq
            )
        );
        echo "<script>alert('게시글이 수정되었습니다.');</script>";
        echo "<meta http-equiv='refresh' content='0; url=read.php?seq=$seq' />";
    }

    else {
        echo "<script type='text/javascript'>alert('수정 권한이 없습니다.');</script>";
        echo "<meta http-equiv='refresh' content='0; url=list.php' />";
    }
}
?>
<!DOCTYPE html>
<head><title>게시글 수정</title></head>
<body>
    <h4>게시글을 수정합니다.</h4>
    <div>
        <form method="post" action="">
            <input type="hidden" value="<?php echo $board['seq']; ?>" />
            <textarea name="content"><?php echo $board['content']; ?></textarea>
            <input type="submit" value="수정하기">
        </form>
    </div>
</body>
</html>