<?php

if(!isset($_SESSION["userid"])) {

?>
    <script>
    alert('로그인 후 이용해 주세요.');
    history.back();
    </script>
<?php
}

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
$sql = "SELECT * FROM goods WHERE id='$session_id' ORDER BY num DESC";
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

$sql = "SELECT * FROM goods WHERE id='$session_id' ORDER BY num DESC LIMIT $s_point, $list";
$real_data = mysqli_query($conn, $sql);

$num = mysqli_num_rows($real_data);

?>
<SCRIPT type="text/javascript">

function reverse_counter(dates){
        
        today = new Date();
        d_day = new Date(dates);
        days = (d_day - today) / 1000 / 60 / 60 / 24;
        daysRound = Math.floor(days);
        hours = (d_day - today) / 1000 / 60 / 60 - (24 * daysRound);
        hoursRound = Math.floor(hours);
        minutes = (d_day - today) / 1000 /60 - (24 * 60 * daysRound) - (60 * hoursRound);
        minutesRound = Math.floor(minutes);
        seconds = (d_day - today) / 1000 - (24 * 60 * 60 * daysRound) - (60 * 60 * hoursRound) -
        (60 * minutesRound);
        secondsRound = Math.round(seconds);
        
        min = " : "
        hr = " : "
        dy = " : "

        time_full=daysRound + 
        dy + hoursRound + hr + minutesRound + min + secondsRound;

        //window.alert(dates+'회원가입이 완료되었습니다.');

        //return time_full;

        if(days<0){
                time_full = '종료';
        }

        document.write(time_full);
        //document.item_time2.counter_box.value = daysRound + dy + hoursRound + hr + minutesRound + min + secondsRound;
        //newtime = window.setTimeout("reverse_counter(dates);", 1000);
}

</script>
<script>
    function goods_stop(num){
        window.open('../section/sale/stop.php?num='+num,'stopview','width=450,height=200,top=100,left=100');
    }
</script>
<div id="section_title" ><?php echo $subhead ?></div>
<div class="board_list_wrap">
    <div class="board_list">
        <div class="board_list_head">
            <div class="num">상품번호</div>
            <div class="tit">상품명</div>
            <div class="wrter">남은기간</div>
            <div class="date">현재 입찰가</div>
            <!--<div class="view">입찰 상태</div>-->
            <div class="hit">조회수</div>
            <div class="hit">수정</div>
            <div class="hit">중지</div>
        </div>
        <?php
        for($i=0; $i<$num; $i++){
            $row = mysqli_fetch_array($real_data);
    
            $item_num=$row["num"];
            $item_time=$row["goods_time"];
            $item_price=$row["goods_price"];
            $item_complete=$row["complete"];
            $item_hit=$row["hit"];
            $item_subject=str_replace(" ", "&nbsp;", $row["subject"]);
            
            $test_num[$i]=$item_num;

            $item_complete=$row["complete"];
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

            $time_full = substr($item_time, 0, 10);

            if(!isset($item_complete)){
                $complete="진행중";
            }else{
                $complete="완료";
            }
            //if($row == false){break;}
        ?>
        <div class="board_list_body">
            <div class="board_item">
                <div class="num"><?=$item_num?></div>
                <div class="tit"><a href="../../feed/goods1.php?number=<?=$item_num?>"><?=$item_subject?></a></div>
                <?php
                if(!strcmp($item_complete, 'end')){
                    $disabled='disabled';
                ?>
                <div class="wrter">종료</div>
                <?php
                }elseif(!strcmp($item_complete, 'stop')){
                    $disabled='disabled';    
                ?>
                <div class="wrter">중지</div>
                <?php
                }else{
                    $disabled='';    
                ?>
                <div class="wrter"><?php echo "<script>reverse_counter('$item_time');</script>";?></div>
                <?php
                }?>
                <div class="date"><?=$item_price?></div>
                <!--<div class="view"><?=$complete?></div>-->
                <div class="hit"><?=$item_hit?></div>
                <div class='modified'>
                    <form action='../feed/sale_form.php' method='get'>
                        <input type='hidden' name='enrollment' value="ing">
                        <input type='hidden' name='modified' value="ing">
                        <input type='hidden' name='goods_num' value="<?=$item_num?>">
                        <button type='submit' <?=$disabled?>>수정</button>
                    </form>
                </div>
                <div class='stop'>
                    <button onclick=goods_stop(<?=$test_num[$i]?>) <?=$disabled?>>중지</button>
                    <input type="hidden" id="pInput" name='test_num[]' value='<?=$test_num[$i]?>'>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
</div>
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