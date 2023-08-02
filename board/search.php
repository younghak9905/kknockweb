<?php
require_once("../main/header.php"); 
session_start();
if (isset($_SESSION['id']) === false){
    header("Location: ../main/index.php");
    exit();
}
require_once("../main/db.php");

$order = "desc"; 
if (isset($_GET['order']) && $_GET['order'] === "asc") {
    $order = "asc"; 
}
$category = $_GET['category'];
$search = $_GET['search'];

$boards = db_select("SELECT * FROM board WHERE " . $category . " LIKE :search ORDER BY seq " . $order, 
array(':search' => '%' . $search . '%'));

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>게시판 목록</title>
</head>
<body>
    <h2>게시판 검색 결과</h2>
    <form action="" method="get">
        <input type="hidden" name="category" value="<?php echo $category; ?>" />
        <input type="hidden" name="search" value="<?php echo $search; ?>" />
        <select name="order" onchange="this.form.submit()">
            <option value="desc" <?php if($order === "desc") echo "selected"; ?>>최신순</option>
            <option value="asc" <?php if($order === "asc") echo "selected"; ?>>오래된 순</option>
        </select>
    </form>
    <table>
        <thead>
            <tr>
                <th width="70">번호</th>
                <th width="500">제목</th>
                <th width="120">글쓴이</th>
                <th width="100">작성일</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach ($boards as $board) {
            $seq = $board['seq'];
            $title = $board['title'];
            $user_name = $board['user_name'];
            $date = $board['date'];

            echo "<tr>";
            echo "<td width='70'>$seq</td>";
            echo "<td width='500'><a href=\"read.php?seq={$board['seq']}\">$title</a></td>";
            echo "<td width='120'>$user_name</td>";
            echo "<td width='100'>$date</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
    <?php
      if($boards == null)
      {
          echo "<br>검색 결과가 없습니다.<br>";
      }
    ?>

    <form action="search.php" method="get">
      <select name="category">
        <option value="title">제목</option>
        <option value="user_name">글쓴이</option>
        <option value="content">내용</option>
      </select>
      <input type="text" name="search" size="40" required="required" /> <button>검색</button>
    </form>
    <a href="list.php"><button>목록으로</button></a>
</body>
</html>
