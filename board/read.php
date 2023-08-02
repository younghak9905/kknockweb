<?php
require_once("../main/db.php");
require_once("../main/header.php"); 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['id']) === false){
    header("Location: ../main/index.php");
    exit();
}
?>
<!doctype html>
<head>
    <meta charset="utf-8">
    <title>게시판</title>
</head>
<body>
    <?php
        $seq = $_GET['seq'];
        $boardArray = db_select("select * from board where seq =?", array($seq));
        $board = $boardArray[0];
    ?>
    <h2><?php echo $board['title']; ?></h2>
    <div>
        <?php 
        echo "작성자 : ";
        echo $board['user_name'];
        echo "<br>";
        echo "작성일 : ";
        echo $board['date'];
        ?>
    </div>
    <br><br>
        <?php echo nl2br("$board[content]"); ?>
    <div>
        <br><br>
        <label><a href="./upload/<?php echo $board['file'];?>" download><?php echo $board['file']; ?>파일</a></label><br>
        <label><a href="modify.php?seq=<?php echo $board['seq']; ?>">수정</a></label>
        <label><a href="delete.php?seq=<?php echo $board['seq']; ?>">삭제</a></label><br>
        <label><a href="list.php">목록으로</a></label><br>
    </div><br><br><br><br>

<!--댓글-->
    <div>
        <h3>댓글</h3>
        <?php
        $replys = db_select("select * from reply where con_num =?", array($seq));

        foreach ($replys as $reply) {    
            echo "작성자: ";
            echo $reply['name'];
            echo "&nbsp;&nbsp;";
            echo "작성일: ";
            echo $reply['date'];     
            echo "<br>";
            echo nl2br("$reply[content]");    
            echo "<br>";
            echo "<label><a href='reply_modify.php?seq=".$reply['seq']."&con_num=".$reply['con_num']."'>수정</a></label>&nbsp;&nbsp;";
            echo "<label><a href='reply_delete.php?seq=".$reply['seq']."'>삭제</a></label>";
            echo "<br><br><br>";
        }
        ?>
    </div>
    <div class="reply_input">
		<form action="reply_check.php?seq=<?php echo $seq; ?>" method="post">
			<div style="margin-top:10px; ">
				<textarea name="content"></textarea>
				<button>댓글</button>
			</div>
		</form>
	</div>
    
</body>
</html>