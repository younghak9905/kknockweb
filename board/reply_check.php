<?php
	require_once("../main/db.php");
    session_start();
    if (isset($_SESSION['id']) === false){
        header("Location: ../main/index.php");
        exit();
    }
    $r_id=$_SESSION['id'];
    $bno = $_GET['seq'];
    $nameArray = db_select("select name from user_table where id =?", array($r_id));
    $name = $nameArray[0]['name'];
    $date = date('Y-m-d');

    if($bno && $_POST['content'] && $r_id){
        $sql = db_insert("insert into reply (con_num, name, id, content, date) values (:con_num, :name, :id, :content, :date)", 
        array(
            'con_num' => $bno,
            'name' => $name,
            'id' => $r_id,
            'content'=> $_POST['content'],
            'date' => $date
        )
    );
        echo "<script>alert('댓글이 작성되었습니다.');</script>";
        echo "<meta http-equiv='refresh' content='0; url=read.php?seq=$bno' />";
    }
    else{
        echo "<script>alert('댓글 작성에 실패했습니다.');</script>";
        echo "<meta http-equiv='refresh' content='0; url=read.php' />";
    }
	
?>