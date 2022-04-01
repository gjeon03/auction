<?php
session_start();

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

                $type=$user['sns_type'];
                $bidder_id=$user['bidder_id'];
                $user_id=$user['id'];
                $phone1=$user['phone'];

                $my_type=$user['my_sns_type'];
                
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

                if(!strcmp($item_complete, 'end')){
                        $complete="완료";
                }elseif(!strcmp($item_complete, 'stop')){
                        $complete="중지";
                }else{
                        $complete="진행중";
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
        if($item_price<5000){
                $min=$item_price+100;
        }elseif($item_price<10000){
                $min=$item_price+500;
        }elseif($item_price<50000){
                $min=$item_price+1000;
        }elseif($item_price<100000){
                $min=$item_price+5000;
        }else{
                $min=$item_price+10000;
        }
        

        //mysqli_query($conn,"UPDATE goods SET complete='end' WHERE num=$view_num");
        //echo "UPDATE goods SET complete='end' WHERE num=$view_num";
}

//쿠키로 최근 본 항목 저장
require('/usr/local/apache2.4/htdocs/today_cookie/goods_cookie.php');

$if_url='../ifram_img.php?location='.$file_location.'&name='.$image_copied_[0];

?>
<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script type="text/javascript">
        //버튼 클릭시 이미지 변경
	function changeImg(num){
                var js_array = <?php echo json_encode($image_copied_)?>;
                //alert(js_array+'비밀번호를 정확히 입력해주세요.');
		//var img2 = document.getElementByld('img2');
		//img2.src = "../ac_loadfile2/"+js_array[num];
                //location="../ac_loadfile2/"+js_array[num];
                //document.getElementById("img22").getAttribute('src')=location;
                //document.getElementById("img").src = "./images/rose.jpg";

                location1="../ac_loadfile2/"
                name=js_array[num];

                ifrm11.location.href="../ifram_img.php?location="+location1+"&name="+name;
	}
</script>

<SCRIPT type="text/javascript">

function reverse_counter(){

        var dates='<?=$item_time?>';

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

        full_time = daysRound + 
        dy + hoursRound + hr + minutesRound + min + secondsRound;
        
        if(d_day-today<0){
                full_time = '00:00:00:00';

                <?php
                //$conn = new mysqli('localhost', 'root', 'LovelY-Su', 'member', '3306');
                //mysqli_query($conn, "set names utf8");

                /*if(isset($item_complete)){
                        if(strcmp($item_complete, 'end')){
                                
                                $title1='낙찰 완료하였습니다.';
                                //$phone=$_SESSION['phone'];
                                $content1='('.$title.')  낙찰 완료되었습니다.'.'<br>'.'판매자 연락처 : '.$phone1;
                                
                                $sql = "INSERT INTO note (from_nick, to_id, name, nick, title, content, regist_day, sns_type) VALUES ('관리자', '$bidder_id', '$name', '$nickname', '$title1', '$content1', now(), '$type')";
                                mysqli_query($conn, $sql);

                                //$s_id=$_SESSION['userid'];
                                $s_nick=$_SESSION['nickname'];
                                $s_name=$_SESSION['username'];
                                $title2='등록하신 경매가 종료되었습니다.';
                                $phone=$_SESSION['phone'];
                                $content2='('.$title.')  낙찰 완료되었습니다.'.'<br>'.'구매자 연락처 : '.$phone;

                                $sql = "INSERT INTO note (from_nick, to_id, name, nick, title, content, regist_day, sns_type) VALUES ('관리자', '$user_id', '$s_name', '$s_nick', '$title2', '$content2', now(), '$my_type')";
                                mysqli_query($conn, $sql);
                                

                                //echo "<script>db_save()</script>";
                        }
                        
                }*/
                //require '../index2.php';
                //$com='end'; 
                //mysqli_query($conn,"UPDATE goods SET complete='end' WHERE num=$view_num");
                ?>
                
                num='<?=$view_num?>';
                //alert("아이디를 제대로 입력해주세요.");
                ifrm1.location.href="../index2.php?view_num="+num;
                        
        }else{
                <?php mysqli_query($conn,"UPDATE goods SET complete='ing' WHERE num=$view_num");?>
        }
        
        document.counter.counter_box.value = full_time;
        newtime = window.setTimeout("reverse_counter();", 1000);
}

</script>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../css/main.css">
        <link rel="stylesheet" type="text/css" href="../css/store_section1.css">
        <link rel="stylesheet" type="text/css" href="../css/store_section2.css">
    </head>
    <body onLoad="reverse_counter()">
        <script>
                function db_save(){
                
                        num=<?=$view_num?>;
                        //alert("아이디를 제대로 입력해주세요.");
                        ifrm1.location.href="../index2.php?view_num="+num; 
                }
        </script>
        <iframe src="" id="ifrm1" scrolling="no" frameborder="no" width="0" height="0" name="ifrm1"></iframe>
        <div id="wrap">
                <div id="header">
                        <?php include "../header/top_login.php"; ?>
                </div>
                <div id="menu">
                        <?php include "../nav/top_menu.php"; ?>
                </div>
                <div id="content">
                        <div id="section">
                                <div id="goods_title" >[NO.<?=$item_num?>]  <?=$title?></div>
                                <div id="goods">
                                        <!--<img id="img2" name="img22" src="<?=$file_location?><?=$image_copied_[0]?>"-->
                                        <div id="img2">
                                                <iframe src=<?=$if_url?> id="ifrm11"  frameborder="no" width="420" height="560" name="ifrm11"></iframe>
                                        </div>
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
                                                <div id="goods_img3" onclick=changeImg(<?php echo $i?>)>
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
                                                                        <input type="text" name="counter_box" size="30" >
                                                                </form>
                                                        </div>
                                                </div>
                                                <div id="goods_money">
                                                        <div id="goods_money1">현재 입찰가 : </div>
                                                        <div id="goods_money2"><?=$item_price?> 원</div>
                                                </div>
                                                <form id="goods_bidding" method='get' action='../section/store/bidding_insert.php'>
                                                        <?php
                                                        if(!strcmp($item_complete, 'end')||!strcmp($item_complete, 'stop')){
                                                                ?>
                                                                <p><input type="text" id="bidding_money" name='bidding_money' placeholder="입찰 희망 금액"> 원</p>
                                                                <input type="button" id="bidding" value="종료" disabled>
                                                                <?php
                                                        }else{
                                                                ?>
                                                                <p><input type="text" id="bidding_money" name='bidding_money' placeholder="입찰 희망 금액"> 원</p>
                                                                <input type='hidden' name='num' value=<?=$view_num?>>
                                                                <input type='hidden' name='min' value=<?=$min?>>
                                                                <?php
                                                                if(isset($_SESSION['userid'])){
                                                                        ?>
                                                                <input type='hidden' name='min_id' value=<?=$_SESSION['userid']?>>
                                                                <input type='hidden' name='sns' value=<?=$_SESSION['sns_type']?>>
                                                                <?php
                                                                }?>
                                                                <input type="submit" id="bidding" value="입찰" >
                                                                <div id='min'>최소 입찰 가능 금액 : <?=$min?> 원</div>
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
                                                <th scope="row">판매자 닉네임</th>
                                                <td><?=$nickname?></td>
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
                                                                if(isset($_SESSION['userid'])){
                                                                if(!strcmp($ripple_id, $_SESSION['userid'])){
                                                                        ?>
                                                                        <a href='../section/store/ripple_del.php?view_num=<?=$view_num?>&num=<?=$ripple_num?>'>[삭제]</a>
                                                                <?php
                                                                }
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
                        </div>
                        <div id="right">
                                <?php include "../wrap_sidebar/right.php"?>
                        </div>
                </div>
                <div id='footer'>
                        <?php include "../footer/footer.php"; ?>
                </div>
        </div>
    </body>
</html>

