<?php

$a=$_GET["category"];
$b="notice";
$c="status";
$num=0;

if (!isset($_GET["category"])){
    $subhead="공지사항";
} 
if(!strcmp($a, $c)){
    $subhead="문의 현황";
}
if(!isset($_SESSION["userid"])) {
    echo "<script>alert('로그인 후 이용해 주세요.');history.back();</script>";
}else{
    
    if(isset($_GET['category'])){
        $a=$_GET["category"];
        #$b="status";
        $c="enrollment";
    
        if(!strcmp($a, $c)){
            $subhead="상품 등록";
        }
    }else {
        $subhead="등록 현황";
    }
    
    $conn = new mysqli('localhost', 'root', 'LovelY-Su', 'member', '3306');
    mysqli_query($conn, "set names utf8");
    
    $session_id = $_SESSION['userid'];
    
    //페이징
    $sql = "SELECT * FROM question WHERE id='$session_id' ORDER BY num DESC";
    //$num = mysqli_num_rows($sql);
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    
    //page 변수를 GET으로 주고 최초 페이지에서도 $page 가 1
    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }else{
        $page = 1;
    }
    
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
        $pageNum=1;
        //echo "<script>history.back();</script>";
    }
    ///////////////////////////////////////////////////////////////// 
    
    $s_point = ($page-1)*$list;

    if(!strcmp($_SESSION['userid'], 'jeon')){
        $sql = "SELECT * FROM question ORDER BY num DESC LIMIT $s_point, $list";
        $real_data = mysqli_query($conn, $sql);
    }else{
        $sql = "SELECT * FROM question WHERE id='$session_id' ORDER BY num DESC LIMIT $s_point, $list";
        $real_data = mysqli_query($conn, $sql);
    }
    
    
    $num = mysqli_num_rows($real_data);
}

?>

<div id="section_title" ><?php echo $subhead ?></div>
<div class="board_list_wrap">
    <div class="board_list">
        <div class="board_list_head">
            <div class="num">번호</div>
            <div class="tit">제목</div>
            <div class="wrter">글쓴이</div>
            <div class="date">작성일</div>
            <div class="view">답변</div>
        </div>
        <?php
        for($i=0; $i<$num; $i++){
            $row = mysqli_fetch_array($real_data);
    
            $item_num=$row["num"];
            $item_nick=$row["nick"];
            $item_complete=$row["complete"];
            $item_date=$row["regist_day"];
            $item_date=substr($item_date, 0, 10);
            $item_hit=$row["hit"];
            $item_subject=str_replace(" ", "&nbsp;", $row["subject"]);

            if(!isset($item_complete)){
                $complete="진행중";
            }else{
                $complete="완료";
            }
            //if($row == false){break;}
            //$numbers=$num-$i;
        ?>
        <div class="board_list_body">
            <div class="board_item">
                <div class="num"><?=$item_num?></div>
                <div class="tit"><a href="../../feed/service_center_form.php?question_view=<?=$item_num?>"><?=$item_subject?></a></div>
                <div class="wrter"><?=$item_nick?></div>
                <div class="date"><?=$item_date?></div>
                <div class="view"><?=$complete?></div>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
    <?php
    if(strcmp($_SESSION['userid'], 'jeon')){
    ?>
    <form class="writing" action="../feed/service_center_form.php" method="get">
        <button type="submit" name="write" value="ing">문의하기</button> 
    </form>
    <?php
    }?>
    <div class="paging">
        <a href="#" class="first">처음 페이지</a>
        <a href="#" class="prev">이전 페이지</a>
        <a href="#" class="num">1</a>
        <a href="#" class="next">다음 페이지</a>
        <a href="#" class="last">마지막 페이지</a>
    </div>
</div>