<?php
$file_dir = '../ac_loadfile2/';

$title="";

if(isset($_GET["number"])){

        $conn = new mysqli('localhost', 'root', 'LovelY-Su', 'member', '3306');
        mysqli_query($conn, "set names utf8");

        $view_num = $_GET['number'];
        
        $sql_user_info = "SELECT * FROM goods WHERE num='$view_num'";

        $result_user_info = mysqli_query($conn, $sql_user_info);
        foreach($result_user_info as $user){

                $title=$user['subject'];
                $nickname=$user['nick'];
                $item_date = $user["regist_day"];
                //$item_date = substr($item_date,0,10);
                $content=$user['content'];
                $image_name_[0]=$user['file_name_0'];
                $image_name_[1]=$user['file_name_1'];
                $image_name_[2]=$user['file_name_2'];
                $image_name_[3]=$user['file_name_3'];
                $image_name_[4]=$user['file_name_4'];
                $image_copied_[0]=$user['file_copied_0'];
                $image_copied_[1]=$user['file_copied_1'];
                $image_copied_[2]=$user['file_copied_2'];
                $image_copied_[3]=$user['file_copied_3'];
                $image_copied_[4]=$user['file_copied_4'];

                $item_num=$user["num"];
                $item_time=$user["goods_time"];
                $item_price=$user["goods_price"];
                $item_complete=$user["complete"];
                $item_model=$user['model'];
                $item_brand=$user['brand'];
                $item_term=$user['term'];
                $item_rating=$user['goods_rating'];
                $name=$user['name'];
                
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
                }
                if($item_time>9){
                        $item_second=$item_time;
                }elseif($item_time==0){
                        $item_second="00";
                }else{
                        $item_second="0".$item_time;
                }*/
                //second
                //$time_full = (string)$item_day.":".(string)$item_times.":".(string)$item_minutes.":".$item_second;
                $time_full = substr($item_time, 0, 10);

                if(!isset($item_complete)){
                        $complete="진행중";
                }else{
                        $complete="완료";
                }

                $hit=$user['hit'] + 1;

        }

        mysqli_query($conn,"UPDATE goods SET hit = $hit WHERE num = $view_num");

        $file_location = "../ac_loadfile2/";
        //$menu="community:";

        $sql_ripple = "SELECT * FROM goods_ripple WHERE parent='$view_num' ORDER BY num ASC";

        $real_ripple = mysqli_query($conn, $sql_ripple);

        //$real_ripple =array_reverse($real_ripple);

        $count = mysqli_num_rows($real_ripple);

}

//쿠키로 최근 본 항목 저장
require('/usr/local/apache2.4/htdocs/today_cookie/goods_cookie.php');

?>
<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script type="text/javascript">
        //버튼 클릭시 이미지 변경
	function changeImg(num){
                alert('비밀번호를 정확히 입력해주세요.');
		var img2 = document.getElementByld('img3');
		img2.src = "../ac_loadfile2/"
	}
</script>

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
        sec = " : "
        min = " : "
        hr = " : "
        dy = " : "
        document.counter.counter_box.value = daysRound + 
        dy + hoursRound + hr + minutesRound + min + secondsRound + sec;
        newtime = window.setTimeout("reverse_counter();", 1000);
}

</script>

<link rel="stylesheet" type="text/css" href="../css/store_section2.css">
<div id="goods_title" >[NO.<?=$item_num?>]  <?=$title?></div>
<div id="goods">
        <img id="img2" src="<?=$file_location?><?=$image_copied_[0]?>">
        <div id="goods_img2">
                <?php
                $image_num =0;
                for($i =0; $i <5; $i++){
                        if(strcmp($image_copied_[$i], "")){
                                $image_num ++;
                        }
                }
                for ($i=0; $i<$image_num; $i++) {
                        $img_location=$file_location.$image_copied_[$i];
                ?>
                <div id="goods_img3" onclick=changeImg($image_copied_[$i])>
                        <img class="img3" src="<?=$file_location?><?=$image_copied_[$i]?>" >
                </div>
                <?php
                }?>
        </div>
        <div id="goods2">
                <div id="goods_name"><?=$item_model?></div>
                <div id="goods_time">
                        <div id="goods_time1">남은 시간 : </div>
                        <div id="goods_time2">
                                <form name="counter">
                                <?php echo "<script>reverse_counter('$item_time');</script>";?>
                                        <input type="text" name="counter_box" size="30" >
                                </form>
                        </div>
                </div>
                <div id="goods_money">
                        <div id="goods_money1">현재 입찰가 : </div>
                        <div id="goods_money2"><?=$item_price?> 원</div>
                </div>
                <form id="goods_bidding">
                        <?php
                        if(!isset($item_complete)){
                                ?>
                                <p><input type="text" id="bidding_money" placeholder="입찰 희망 금액"> 원</p>
                                <input type="button" id="bidding" value="입찰" >
                                <?php
                        }else{
                                ?>
                                <p><input type="text" id="bidding_money" placeholder="입찰 희망 금액"> 원</p>
                                <input type="button" id="bidding" value="종료" disabled>
                                <?php
                        }
                        ?>
                </form>
        </div>
</div>
<div id="detail_title1">상품정보</div>
<table class="detail1">
        <tr>
                <th scope="row">브랜드</th>
                <td><?=$item_brand?></td>
        </tr>
        <tr>
                <th scope="row">모델명</th>
                <td><?=$item_model?></td>
        </tr>
        <tr>
                <th scope="row">사용기간</th>
                <td><?=$item_term?></td>
        </dtriv>
        <tr>
                <th scope="row">품질</th>
                <td><?=$item_rating?></td>
        </tr>
        <tr>
                <th scope="row">판매자 이름 / 닉네임</th>
                <td><?=$name?> / <?=$nickname?></td>
        </tr>
</table>
<div id=detail_title2>상세 설명</div>
<div id="detail2"><?=$content?></div>
<div id='ripple_title'>댓글</div>
<?php
if($count>0){
        ?>
        <div id='ripple1'>
                <?php
        for($i=0; $i<$count; $i++){
                $row = mysqli_fetch_array($real_ripple);

                //$row=array_reverse($row);
                $ripple_num=$row["num"];
                $ripple_content=$row["content"];
                $ripple_id=$row["id"];
                $ripple_nick=$row["nick"];
                $ripple_date=$row["regist_day"];
                $ripple_date=substr($ripple_date, 0, 10);
                ?>
                <div id='ripple_nick'><?=$ripple_nick?></div>
                <div id='ripple2'>
                        <div id='ripple_con'><?=$ripple_content?></div>
                        <div id='ripple_date'>
                                <?php
                                if(!strcmp($ripple_id, $_SESSION['userid'])){
                                        ?>
                                        <a href='../section/store/ripple_del.php?view_num=<?=$view_num?>&num=<?=$ripple_num?>'>[삭제]</a>
                                <?php
                                }
                                ?>
                                <?=$ripple_date?>
                        </div>
                </div>
                <?php
        }
        ?>
        </div>
        <?php
}
?>
<div id="view_comment">
        <form action='../section/store/insert_ripple.php' method='post'>
        <table>
                <tr>
                        <th>댓글</th>
                        <td>
                                <input type='hidden' name='num' value=<?=$view_num?>>
                                <textarea name="ripple_content" rows="6" cols="125"></textarea></td>
                                <button type='submit' id='ripple_btn'>등록</button>
                        </td>
                </tr>
        </table>
        </form>
</div>

