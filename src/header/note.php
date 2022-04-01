<?php
session_start();

$conn = new mysqli('localhost', 'root', 'LovelY-Su', 'member', '3306');
mysqli_query($conn, "set names utf8");

/*$sql = "SELECT * FROM free";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo "아이디: " . $row["id"]. "이름:"  . $row["name"]. " 내용:" . $row["content"]. "<br>";
    }
}else{
    echo "테이블에 데이터가 없습니다.";
}*/
/////////////////////////////////////////////////////////////////

$id=$_SESSION['userid'];
$note_sns =$_SESSION['sns_type'];

//페이징
$sql = "SELECT * FROM note WHERE to_id='$id' AND sns_type='$note_sns' ORDER BY num DESC";   

//$num = mysqli_num_rows($sql);
$result = mysqli_query($conn, $sql);
$num = mysqli_num_rows($result);

//page 변수를 GET으로 주고 최초 페이지에서도 $page 가 1
if(isset($_GET['page'])){
    $page = $_GET['page'];
}else{
    $page = 1;
}

//$data = mysql_query("SELECT num FROM free ORDER BY num DESC");
//$num = mysql_num_rows($data);

$list = 10; //페이지 당 데이터 수
$block = 5; //블록 당 페이지 수

//나눠주는데 소숫점이 생길 수 있기에 ceil로 막아준다.
$pageNum = ceil($num/$list);//총 페이지
$blockNum = ceil($pageNum/$block);//총 블록
$nowBlock = ceil($page/$block);//현재 위치한 블록 번호

//블록 당 시작과 종료
$s_page = ($nowBlock * $block) - ($block - 1);

if($s_page <= 1){
    $s_page = 1;
}
$e_page = $nowBlock*$block;
if($pageNum <= $e_page){
    $e_page = $pageNum;
}

//page값이 해당 없는 값이 왔을때
if($page < 1){
    echo "<script>history.back();</script>";
}
if($page > $pageNum){
    //echo "<script>history.back();</script>";
}
/////////////////////////////////////////////////////////////////

$s_point = ($page-1)*$list;

$sql = "SELECT * FROM note WHERE to_id='$id' AND sns_type='$note_sns' ORDER BY num DESC LIMIT $s_point, $list";   

//$sql = "SELECT * FROM free ORDER BY num DESC LIMIT $s_point, $list";
$real_data = mysqli_query($conn, $sql);

$num = mysqli_num_rows($real_data);

//$row = mysqli_fetch_assoc($real_data);
/*while($row = mysqli_fetch_assoc($real_data)) {
    echo "아이디: " . $row["id"]. "이름:"  . $row["name"]. " 내용:" . $row["content"]. "<br>";
}*/

/*$sql = "SELECT * FROM free";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo "아이디: " . $row["id"]. "이름:"  . $row["name"]. " 내용:" . $row["content"]. "<br>";
    }
}else{
    echo "테이블에 데이터가 없습니다.";
}*/

?>
<link rel="stylesheet" type="text/css" href="../css/note.css">
<div id='note_main'>
    <div id="section_title" >쪽지</div>
    <div class="board_list_wrap">
        <form class="writing" action="note_del.php" method="post">
            <div class="board_list">
                <div class="board_list_head">
                    <div class="check">체크</div>
                    <!--<div class="num">번호</div>-->
                    <div class="tit">제목</div>
                    <div class="wrter">보낸사람</div>
                    <div class="date">날짜</div>
                </div>
                <?php
                for($i=1; $i<$num+1; $i++){
                    $row = mysqli_fetch_array($real_data);
            
                    $item_num=$row["num"];
                    $note_from_nick=$row["from_nick"];
                    $to_id=$row["to_id"];
                    
                    $note_title=$row["title"];
                    $content=$row["content"];
                    $note_date=$row["regist_day"];
                    $note_date=substr($note_date, 0, 10);
                    $note_sns_type=$row["sns_type"];
                    
                    //if($row == false){break;}
                    $j=$num-$i+1;
                ?>
                <div class="board_list_body">          
                    <div class="board_item">
                        <input type='checkbox' name='num[]'value=<?=$item_num?>>
                        <!--<div class="num"><?= $j*$page?></div>-->
                        <div class="tit" ><a href="note_view.php?note_view=<?=$item_num?>"><?= $note_title?></a></div>
                        <div class="wrter1"><?= $note_from_nick ?></div>
                        <div class="date1"><?= $note_date ?></div>
                    </div>
                </div>
                <?php }?>
            </div>
            <?php
            if(isset($_SESSION['userid'])){
                ?>
                <input type='hidden' name='del' value="ing">
            <button type="submit" name="writing" value="ing">삭제</button> 
        </form>
        <?php
        }?>
        <div class="paging">
            <a href="<?=$_SERVER['PHP_SELF']?>?page=1" class="first">처음 페이지</a>
            <a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$page-1?>" class="prev">이전 페이지</a>
            <?php
            for($p=$s_page; $p <= $e_page; $p++){
            ?>
            <a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$p?>" class="num"><?=$p?></a>
            <?php
            }
            ?>
            <a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$page+1?>" class="next">다음 페이지</a>
            <a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$pageNum?>" class="last">마지막 페이지</a>
        </div>
    </div>
</div>