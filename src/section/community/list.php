<?php
//session_start();

$b="total";
$a="";
$c="benefit";
$d="game";
$e="chat";
$f="greetings";
$g="etc";

if (!isset($_GET["category"])){
    $subhead="전체";
}else{
    $a=$_GET["category"];

    if(!strcmp($a, $b)){
        $subhead="전체";
    } elseif(!strcmp($a, $c)){
        $subhead="개이득";
        $b=$c;
    } elseif(!strcmp($a, $d)){
        $subhead="게임";
        $b=$d;
    } elseif(!strcmp($a, $e)){
        $subhead="수다";
        $b=$e;
    } elseif(!strcmp($a, $f)){
        $subhead="가입인사";
        $b=$f;
    } elseif(!strcmp($a, $g)){
        $subhead="기타";
        $b=$g;
    }
}
require('../section/community/_conn.php');

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
//페이징
if(isset($_GET["category"])&&strcmp($_GET["category"],'total')){
    if(isset($_GET['find'])&&isset($_GET['search'])){
        $find=$_GET['find'];
        $search=$_GET['search'];

        $sql = "SELECT * FROM free WHERE category='$a' AND $find LIKE '%$search%' ORDER BY num DESC";
    }else{
        $sql = "SELECT * FROM free WHERE category='$a' ORDER BY num DESC";   
    }
}else {
    if(isset($_GET['find'])&&isset($_GET['search'])){
        $find=$_GET['find'];
        $search=$_GET['search'];
        $sql = "SELECT * FROM free WHERE $find LIKE '%$search%' ORDER BY num DESC";
    }else{
        $sql = "SELECT * FROM free ORDER BY num DESC";    
    }
}
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

if(isset($_GET["category"])&&strcmp($_GET["category"],'total')){
    if(isset($_GET['find'])&&isset($_GET['search'])){
        $find=$_GET['find'];
        $search=$_GET['search'];

        $sql = "SELECT * FROM free WHERE category='$a' AND $find LIKE '%$search%' ORDER BY num DESC LIMIT $s_point, $list";
    }else{
        $sql = "SELECT * FROM free WHERE category='$a' ORDER BY num DESC LIMIT $s_point, $list";   
    }
}else {
    if(isset($_GET['find'])&&isset($_GET['search'])){
        $find=$_GET['find'];
        $search=$_GET['search'];
        $sql = "SELECT * FROM free WHERE $find LIKE '%$search%' ORDER BY num DESC LIMIT $s_point, $list";
    }else{
        $sql = "SELECT * FROM free ORDER BY num DESC LIMIT $s_point, $list";   
    }
}
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

<div id="section_title" ><?php echo $subhead ?></div>
<form id="list_search" method="get" action="">
        <input type='hidden' name='category' value=<?=$b?>>
        <div id="list_search1">
                <select name="find">
                <option value='subject'>제목</option>
                <option value='nick'>닉네임</option>
                </select>
        </div>
        <div id="list_search2"><input type="text" name="search"></div>
        <div id="list_search3"><input type="submit" value="검색" ></div>
</form>
<div class="board_list_wrap">
    <div class="board_list">
        <div class="board_list_head">
            <div class="num">번호</div>
            <div class="tit">제목</div>
            <div class="wrter">글쓴이</div>
            <div class="date">작성일</div>
            <div class="view">조회</div>
        </div>
        <?php
        for($i=0; $i<$num; $i++){
            $row = mysqli_fetch_array($real_data);
    
            $item_num=$row["num"];
            $item_id=$row["id"];
            $item_name=$row["name"];
            $item_nick=$row["nick"];
            $item_hit=$row["hit"];
            $item_date=$row["regist_day"];
            $item_date=substr($item_date, 0, 10);
            $item_subject=str_replace(" ", "&nbsp;", $row["subject"]);
            $item_category=$row["category"];
            
            //if($row == false){break;}
        ?>
        <div class="board_list_body">          
            <div class="board_item">
                <div class="num"><?= $item_num ?></div>
                <div class="tit" ><a href="community_form.php?category=<?=$item_category?>&community_view=<?=$item_num?>"><?= $item_subject?></a></div>
                <div class="wrter"><?= $item_nick ?></div>
                <div class="date"><?= $item_date ?></div>
                <div class="view"><?= $item_hit ?></div>
            </div>
        </div>
        <?php }?>
    </div>
    <?php
    if(isset($_SESSION['userid'])){
        ?>
    <form class="writing" action="../feed/community_form.php" method="get">
        <button type="submit" name="writing" value="ing">글쓰기</button> 
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
