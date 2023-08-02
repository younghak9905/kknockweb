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
$board = db_select("select * from board where seq = :seq",
    array(
        'seq' => $seq
    ))[0];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $check = db_select("select * from board where user_id = :user_id and seq = :seq",
    array(
        'user_id' => $id,
        'seq' => $seq
        )
    );

    if(!empty($check)){
        //파일 검사
        if (isset($_FILES['b_file']) && $_FILES['b_file']['error'] === UPLOAD_ERR_OK) {
            $tmpfile =  $_FILES['b_file']['tmp_name'];
            //$o_name = $_FILES['b_file']['name'];
            $filename = time().'-'.rand(1000,9999).'.'.pathinfo($_FILES['b_file']['name'], PATHINFO_EXTENSION);
            $folder = "./upload/".$filename;
            move_uploaded_file($tmpfile,$folder);
        }
        else {
            $filename = null; 
        }

        $edit = db_update_delete("UPDATE board SET content = :content, date = :date, file = :file WHERE seq = :seq", 
            array(
                'content'=> $_POST['content'],
                'date'=> $date,
                'file'=> $filename !== null ? $filename : $board['file'],
                'seq' => $seq
                )
        );
        echo "<script type='text/javascript'>alert('게시글이 수정되었습니다.');</script>";
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
        <form method="post" action="" enctype="multipart/form-data">
            <input type="hidden" value="<?php echo $board['seq']; ?>" />
            <textarea name="content" rows="10" cols="80" required><?php echo $board['content']; ?></textarea><br>
            <input type="file" value="1" name="b_file"><br><br>
            현재 파일 : 
            <?php 
            echo $board['file'];
            echo "<br><br>";
            if (in_array(pathinfo($board['file'], PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif'])) {
                echo "<img src='./upload/".$board['file']."' alt='Current uploaded file' width='200' /><br>";
            }
            ?><br><br>
            <input type="submit" value="수정하기">
        </form>
    </div>
</body>
</html>