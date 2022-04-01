<?php
// view쪽에 cookie값을 뿌리기 위한 소스, 2차원 배열을 사용해 쿠키의 사이즈를 가져와 뿌리도록 설정하였다.
if(isset($_COOKIE['text_today_view'])){
	
	$tod2=explode(",", $_COOKIE['text_today_view']); // today_view 쿠키를 ','로 나누어 구분한다.
    $tod=array_reverse($tod2); // 최근 목록을 뽑기 위해 배열을 최신 값이 0에 오게 한다.(배열을 뒤집음)
}
if(isset($_COOKIE['goods_today_view'])){
	
	$tod3=explode(",", $_COOKIE['goods_today_view']); // today_view 쿠키를 ','로 나누어 구분한다.
    $tod1=array_reverse($tod3); // 최근 목록을 뽑기 위해 배열을 최신 값이 0에 오게 한다.(배열을 뒤집음)
}

$page="";
$text_cookie_category="";
$page_get="";
$text_cookie_title="";
?>

<div id="cookie_goods">
    <div id="cookie_goods_title">
        <div>최근 본 상품</div>
    </div>
    <div id="cookie_goods_body1">
        <div id="cookie_goods_body2" >
        <?php
                if(isset($_COOKIE['goods_today_view'])){
                    //require('../section/community/_conn.php');
                    $conn = new mysqli('localhost', 'root', 'LovelY-Su', 'member', '3306');
                    mysqli_query($conn, "set names utf8");

                    for($i=0; $i<count($tod1); $i++){

                        $page = 'goods1.php';
                        $page_get = 'number';

                        $table="goods";
                        //for($i=0; $i<$num; $i++){
                        //  $row = mysqli_fetch_array($real_data);

                        $sql = "SELECT * FROM $table WHERE num = $tod1[$i]";
                        $real_data = mysqli_query($conn, $sql);

                        $row = mysqli_fetch_assoc($real_data);

                        //$text_cookie_title=$row["subject"]; 
                        //$item_subject=str_replace(" ", "&nbsp;", $row["subject"]);
                        $cookie_image = $row['file_copied_0'];
                        
                        $file_location = "../ac_loadfile2/";
                        //feed/goods1.php?number=7
                        if(strcmp($cookie_image, '')){
                        ?>
                        <div class="goods_cookie2" onclick="location.href='<?=$page?>?<?=$page_get?>=<?=$tod1[$i]?>'"><img src="<?=$file_location?><?=$cookie_image?>"></div>
                        <?php 
                        }               
                    }
				}
				?>
        </div>
    </div>
    <!--<div id="cookie_goods_button">
        <div id="cookie_goods_down" onclick="#">∨</div>
        <div id="cookie_goods_up" onclick="#">∧</div>
    </div>-->
</div>
<div id="cookie_text">
    <div id=cookie_text_title>
        최근 본 커뮤니티
    </div>
    <div id="cookie_text_body1">
        <div id="cookie_text_body2">
                <?php
                if(isset($_COOKIE['text_today_view'])){
                    //require('../section/community/_conn.php');
                    $conn = new mysqli('localhost', 'root', 'LovelY-Su', 'member', '3306');
                    mysqli_query($conn, "set names utf8");

                    for($i=0; $i<count($tod); $i++){
                        
                        $menu=explode(":", $tod[$i]); // today_view 쿠키를 ','로 나누어 구분한다.

                        //카테고리에 따라 값 다르게 주기위해
                        /*if(!strcmp($menu[0], 'notice')){
                            $page = 'service_center_form.php';
                            $page_get = 'notice_view';

                            $table="notice";
                        }elseif(!strcmp($menu[0], 'question')){
                            $page = 'service_center_form.php';
                            $page_get = 'question_view';

                            $table="question";
                        }else {
                            $page = 'community_form.php';
                            $page_get = 'community_view';

                            $table="free";
                            //for($i=0; $i<$num; $i++){
                            //  $row = mysqli_fetch_array($real_data);
                        }*/

                        $page = 'community_form.php';
                        $page_get = 'community_view';

                        $table="free";

                        $sql = "SELECT * FROM free WHERE num = $menu[1]";
                        $real_data = mysqli_query($conn, $sql);

                        $row = mysqli_fetch_assoc($real_data);

                        $text_cookie_title=$row["subject"]; 
                        //$item_subject=str_replace(" ", "&nbsp;", $row["subject"]);
                        if(strcmp($text_cookie_title, '')){
                        ?>
                        <div class="text_cookie2"><a href="<?=$page?>?category=<?=$menu[0]?>&<?=$page_get?>=<?=$menu[1]?>"><?=$text_cookie_title?></a></div>
                        <?php
                        }
                        //if(!strcmp($menu[0], 'notice')||!strcmp($menu[0], 'question')){
                            
                            ?>
                            <!--<div class="text_cookie2"><a href="<?=$page?>?<?=$page_get?>=<?=$menu[1]?>"><?=$text_cookie_title?></a></div>
                            <?php
                        //}else {
                            $text_cookie_category=$row['category'];
                            ?>
                            <div class="text_cookie2"><a href="<?=$page?>?category=<?=$text_cookie_category?>&<?=$page_get?>=<?=$menu[1]?>"><?=$text_cookie_title?></a></div>-->
                            <?php 
                        //}                       
                    }
				}
				?>
        </div>
    </div>
    <!--<div id="cookie_text_button">
        <div id="cookie_text_down" onclick="#">∨</div>
        <div id="cookie_text_up" onclick="#">∧</div>
    </div>-->
</div>