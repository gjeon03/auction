<?php
$a="";
$c="fashion";
$d="beauty";
$e="life";
$f="digital";
$g="interior";
$h="books";
$i="etc";

$b="total";

if(isset($_GET["category"])){
        $a=$_GET["category"];
        #$b="total";
        
        if(!strcmp($a, $b)){
                $subhead="전체";
        }elseif(!strcmp($a, $c)){
                $subhead="패션 의류/잡화";
                $b=$c;
        } elseif(!strcmp($a, $d)){
                $subhead="뷰티";
                $b=$d;
        } elseif(!strcmp($a, $e)){
                $subhead="생활 용품";
                $b=$e;
        } elseif(!strcmp($a, $f)){
                $subhead="가전 디지털";
                $b=$f;
        } elseif(!strcmp($a, $g)){
                $subhead="홈 인테리어";
                $b=$g;
        } elseif(!strcmp($a, $h)){
                $subhead="도서/음반/DVD";
                $b=$h;
        } elseif(!strcmp($a, $i)){
                $subhead="기타";
                $b=$i;
        }
}else {
        $subhead="전체";
}

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
//페이징
if(isset($_GET["category"])&&strcmp($_GET["category"],'total')){
        if(isset($_GET['find'])&&isset($_GET['search'])){
                $find=$_GET['find'];
                $search=$_GET['search'];

                $sql = "SELECT * FROM goods WHERE category='$a' AND $find LIKE '%$search%' ORDER BY num DESC";
        }else{
                $sql = "SELECT * FROM goods WHERE category='$a' ORDER BY num DESC"; 
        }  
}else {
        if(isset($_GET['find'])&&isset($_GET['search'])){
                $find=$_GET['find'];
                $search=$_GET['search'];
                $sql = "SELECT * FROM goods WHERE $find LIKE '%$search%' ORDER BY num DESC";
        }else{
                $sql = "SELECT * FROM goods ORDER BY num DESC";   
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

$list = 12; //페이지 당 데이터 수
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

$find="";
$search="";

if(isset($_GET["category"])&&strcmp($_GET["category"],'total')){
        if(isset($_GET['find'])&&isset($_GET['search'])){
                $find=$_GET['find'];
                $search=$_GET['search'];

                $sql = "SELECT * FROM goods WHERE category='$a' AND $find LIKE '%$search%' ORDER BY num DESC LIMIT $s_point, $list";
        }else{
                $sql = "SELECT * FROM goods WHERE category='$a' ORDER BY num DESC LIMIT $s_point, $list";
        }
}else {
        if(isset($_GET['find'])&&isset($_GET['search'])){
                $find=$_GET['find'];
                $search=$_GET['search'];
                $sql = "SELECT * FROM goods WHERE $find LIKE '%$search%' ORDER BY num DESC LIMIT $s_point, $list";
        }else{
                $sql = "SELECT * FROM goods ORDER BY num DESC LIMIT $s_point, $list";   
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
                <option value='name'>이름</option>
                </select>
        </div>
        <div id="list_search2"><input type="text" name="search"></div>
        <div id="list_search3"><input type="submit" value="검색" ></div>
</form>
<div id="item_list">
        <?php
        for($i=0; $i<$num; $i++){
            $row = mysqli_fetch_array($real_data);
    
            $item_num=$row["num"];
            $item_image=$row["file_copied_0"];
            $item_model=$row["model"];
            $item_price=$row["goods_price"];
            $item_time=$row["goods_time"];
            //$item_subject=str_replace(" ", "&nbsp;", $row["subject"]);
            $item_subject=$row["subject"];
            $item_complete=$row["complete"];

            if(!strcmp($item_complete, 'stop')||!strcmp($item_complete, 'end')){
                $bi_btn='종료';
            }else{
                $bi_btn='입찰하기';
            }
            //$item_category=$row["category"];

            /*$item_times="";
            if($item_time/86400>0){
                $item_days=$item_time/86400;
                $item_time%=86400;
                
                $item_day="0".(string)$item_days;
            }else{
                $item_day="00";
            }
            if($item_time/3600>0){
                $item_time1=$item_time/3600;
                $item_time%=3600;
                //minute
                if($item_time1>9){
                    $item_times=$item_time1;
                }else{
                    $item_times="0".(string)$item_time1;
                }
            }else{
                $item_times="00";
            }
                if($item_time/60>0){
                        $item_minute=$item_time/60;
                        $item_time%=60;
                        if($item_minute>9){
                        $item_minutes=$item_minute;
                        }else{
                        $item_minutes="0".(string)$item_minute;
                        }
                }else{
                        $item_minutes="00";
                }*/
            /*if($item_time>9){
                $item_minute=$item_time;
            }elseif($item_time==0){
                $item_minute="00";
            }else{
                $item_minute="0".$item_time;
            }*/

            //$time_full = (string)$item_day.":".(string)$item_times.":".(string)$item_minutes;
            //$time_full = substr($item_time, 0, 10);
            if(iconv_strlen($item_subject, 'UTF-8')>13){
                $item_subject=iconv_substr($item_subject, 0, 13);
                $item_subject.="...";
            }
            //$j=$num-$i;

            $if_url='../index1.php?number='.$item_num;
            //echo "<script>reverse_counter('$item_time');</script>";
            
        ?>
        <div class="item" onclick="location.href='../../feed/goods1.php?number=<?=$item_num?>';">
                <div class="item_title"><?=$item_subject?></div>
                <img class="img1" src="../ac_loadfile2/<?=$item_image?>">
                <div class="item_name"><?=$item_model?></div>
                <div id='time'>
                        <div class="item_time1">남은 시간 : </div>
                        <div class="item_time2">
                                <iframe src=<?=$if_url?> id="ifrm1"  frameborder="no" width="130" height="50" name="ifrm1"></iframe>        
                        </div>
                </div>
                <div id='price'>
                        <div class="item_money1">현재 입찰가 : </div>
                        <div class="item_money2"><?=$item_price?> 원</div>
                </div>
                <div class="bidding_btn"><?=$bi_btn?></div>
        </div>
        <?php 
        }
        ?>
</div>
<div id="paging">
        <a href="#" class="first">처음 페이지</a>
        <a href="#" class="prev">이전 페이지</a>
        <a href="#" class="num">1</a>
        <a href="#" class="next">다음 페이지</a>
        <a href="#" class="last">마지막 페이지</a>
</div>