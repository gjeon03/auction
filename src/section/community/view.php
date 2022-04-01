<?php
$file_dir = '../ac_loadfile/';

$a='';
$cm_category='';
if(isset($_GET["community_view"])){
        if (isset($_GET["category"])){
                $a=$_GET["category"];
                $c="benefit";
                $d="game";
                $e="chat";
                $f="greetings";
                $g="etc";
                if(!strcmp($a, $c)){
                        $subhead="개이득";
                        $menu=$c.":";
                        $cm_category=0;
                } elseif(!strcmp($a, $d)){
                        $subhead="게임";
                        $menu=$d.":";
                        $cm_category=1;
                } elseif(!strcmp($a, $e)){
                        $subhead="수다";
                        $menu=$e.":";
                        $cm_category=2;
                } elseif(!strcmp($a, $f)){
                        $subhead="가입인사";
                        $menu=$f.":";
                        $cm_category=3;
                } elseif(!strcmp($a, $g)){
                        $subhead="기타";
                        $menu=$g.":";
                        $cm_category=4;
                }
        }else {
                $a='total';
        }

        require('_conn.php');

        $view_num = $_GET['community_view'];
        
        $sql_user_info = "SELECT * FROM free WHERE num='$view_num'";

        $result_user_info = mysqli_query($conn, $sql_user_info);
        foreach($result_user_info as $user){

                $view_id=$user['id'];
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
                $hit=$user['hit'];
        }
        $hits=$hit+1;
        if(isset($_SESSION['community_hit'])){
                if(strcmp($_SESSION['community_hit'],$view_num)){
                        mysqli_query($conn,"UPDATE free SET hit = $hits WHERE num = $view_num");
                        $_SESSION['community_hit']=$view_num;
                }
        }else{
                mysqli_query($conn,"UPDATE free SET hit = $hits WHERE num = $view_num");
                $_SESSION['community_hit']=$view_num;
        }
        $file_location = "../ac_loadfile/";
        $menus="community:";

        $sql_ripple = "SELECT * FROM free_ripple WHERE parent='$view_num' ORDER BY num ASC";

        $real_ripple = mysqli_query($conn, $sql_ripple);

        //$real_ripple =array_reverse($real_ripple);

        $count = mysqli_num_rows($real_ripple);

        //쿠키로 최근 본 항목 저장
        require('/usr/local/apache2.4/htdocs/today_cookie/text_cookie.php');

        //$row = mysqli_fetch_assoc($result);

        /*echo $title=$user['subject']."<br/>";
        echo $nickname=$user['nick']."<br/>";
        echo $item_date = $user["regist_day"]."<br/>";
        echo $item_date."<br/>";
        echo $content=$user['content']."<br/>";
        echo $image_name[0]=$user['file_name_0']."<br/>";
        echo $image_name[1]=$user['file_name_1']."<br/>";
        echo $image_name[2]=$user['file_name_2']."<br/>";
        echo $image_name[3]=$user['file_name_3']."<br/>";
        echo $image_name[4]=$user['file_name_4']."<br/>";
        echo $image_copied[0]=$user['file_copied_0']."<br/>";
        echo $image_copied[1]=$user['file_copied_1']."<br/>";
        echo $image_copied[2]=$user['file_copied_2']."<br/>";
        echo $image_copied[3]=$user['file_copied_3']."<br/>";
        echo $image_copied[4]=$user['file_copied_4']."<br/>";
        echo $hit."<br/>";*/

}
if(isset($_GET["notice_view"])){
        
        $subhead="공지사항";

        require('_conn.php');

        $view_num = $_GET['notice_view'];
        
        $sql_user_info = "SELECT * FROM notice WHERE num='$view_num'";
        
        $result_user_info = mysqli_query($conn, $sql_user_info);
        foreach($result_user_info as $user){

                $view_id=$user['id'];
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
                $hit=$user['hit'];
        }
        $hits=$hit+1;
        
        if(isset($_SESSION['notice_hit'])){
                if(strcmp($_SESSION['notice_hit'], $view_num)){
                        mysqli_query($conn,"UPDATE notice SET hit = $hits WHERE num = $view_num");
                        //mysqli_query($conn,"UPDATE notice SET hit = $hits WHERE num = $view_num");
                        $_SESSION['notice_hit']=$view_num;
                }
        }else{
                mysqli_query($conn,"UPDATE notice SET hit = $hits WHERE num = $view_num");
                $_SESSION['notice_hit']=$view_num;
        }
        
        $file_location = "../ac_noticefile/";
        $menus="notice:";

        $sql_ripple = "SELECT * FROM notice_ripple WHERE parent='$view_num' ORDER BY num ASC";
        
        $real_ripple = mysqli_query($conn, $sql_ripple);

        //$real_ripple =array_reverse($real_ripple);

        $count = mysqli_num_rows($real_ripple);
}
if(isset($_GET["question_view"])){
        $subhead="문의 현황";

        require('_conn.php');

        $view_num = $_GET['question_view'];
        
        $sql_user_info = "SELECT * FROM question WHERE num='$view_num'";

        $result_user_info = mysqli_query($conn, $sql_user_info);
        foreach($result_user_info as $user){

                $view_id=$user['id'];
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
                $hit=$user['hit'];
        }
        $hits=$hit+1;
        if(isset($_SESSION['question_hit'])){
                if(strcmp($_SESSION['question_hit'],$view_num)){
                        mysqli_query($conn,"UPDATE question SET hit = $hits WHERE num = $view_num");
                        $_SESSION['question_hit']=$view_num;
                }
        }else{
                mysqli_query($conn,"UPDATE question SET hit = $hits WHERE num = $view_num");
                $_SESSION['question_hit']=$view_num;
        }

        $file_location = "../ac_questions/";
        $menus="question:";

        $sql_ripple = "SELECT * FROM question_ripple WHERE parent='$view_num' ORDER BY num ASC";

        $real_ripple = mysqli_query($conn, $sql_ripple);

        //$real_ripple =array_reverse($real_ripple);

        $count = mysqli_num_rows($real_ripple);
}

//쿠키로 최근 본 항목 저장
//require('/usr/local/apache2.4/htdocs/today_cookie/text_cookie.php');
//setcookie("text_today_view", '', time()-999999999,"/");
/*$cookiePno = $view_num; // 상품번호
echo "num값은 : ".$cookiePno."<br>";
if(isset($_COOKIE['text_today_view'])){ // today_view라는 쿠키가 존재하면
	//$todayview=$_COOKIE['text_today_view']; // $todayview 변수에 today_view 쿠키를 저장한다.
        //require('/usr/local/apache2.4/htdocs/today_cookie/text_cookie.php');

	//쿠키에 값 추가
	setcookie('text_today_view', $todayview.",".$cookiePno, time() + 3600*24, "/");
        echo "num값은12314235 : ".$cookiePno."<br>";
        echo $_COOKIE['text_today_view']."<br>";
	//변수에 배열로 넣어준값의 중복을 array_unique()로 없애준다.
	//$tod2=explode(",", $_COOKIE['text_today_view']); // today_view 쿠키를 ','로 나누어 구분한다.
	$tod=array_reverse($tod2); // 최근 목록을 뽑기 위해 배열을 최신 값이 0에 오게 한다.(배열을 뒤집음)
	print_r($tod)."<br>";
	//중복제거
	$tod=array_unique($tod);
	print_r($tod)."<br>";
	//쿠키 초기화
	setcookie("text_today_view", '', time()-999999999,"/");
        print_r($tod)."<br>";
        echo "<br>";
        echo "초기화 안되나 : ".$_COOKIE['text_today_view']."<br>";
	//중복을 제거한 배열을 다시 돌려준다.
	$tod=array_reverse($tod);
        print_r($tod)."<br>";
        echo $tod[0];
        print_r($tod)."<br>";
        //require('/usr/local/apache2.4/htdocs/today_cookie/test.php');
	//배열을 합쳐준다.
	/*for($i=0; $i<count($tod); $i++){
		if($i==0){
			setcookie('text_today_view', $tod[$i], time() + 3600*24, "/");
		}else{
			$todayview=$_COOKIE['text_today_view'];
		}
		setcookie('text_today_view', $todayview.",".$tod[$i], time() + 3600*24, "/");
	}*/

/*}else { // 저장된 쿠키값이 없을 경우 새로 쿠키를 저장하는 소스
	echo "<script>window.alert('쿠키 호출2222이 완료되었습니다.')</script>";
	setcookie('text_today_view', $cookiePno, time() + 3600*24, "/");
}*/

//echo "쿠키값 저장됐나 : ".$_COOKIE['text_today_view'];
?>


<div id="section_title" style="font-size:20px"><?php echo $subhead ?></div>
<div id="view">
        <div id="view_top">
                <div id="view_title">제목 : <?=$title?></div>
                <div id="nickname"><?=$nickname?></div>
                <div id="views">조회 : <?=$hit?></div>
                <div id="community_date"><?=$item_date?></div>
        </div>
        <div id="view_main">
                <?php
                $image_num =0;
                for($i =0; $i <5; $i++){
                        if(strcmp($image_copied_[$i], "")){
                                $image_num ++;
                        }
                }
                for ($i=0; $i<$image_num; $i++) {
                ?>
                <div id=images>
                        <img class="img3" src="<?=$file_location?><?=$image_copied_[$i]?>">
                </div>
                <?php
                }?>
                <div id="community_contents">
                        <?=$content?>
                </div>
        </div>
        <div id="view_bottom">
                <?php
                if(isset($_SESSION['userid'])){
                        if((isset($_GET["community_view"])&&!strcmp($view_id, $_SESSION['userid']))||!strcmp($_SESSION['userid'], 'jeon')){
                                ?>
                                <form action='community_form.php?writing=ing' method='post'>
                                        <input type='hidden' name='modified' value='ing'>
                                        <input type='hidden' name='category' value=<?=$a?>>
                                        <input type='hidden' name='menu' value=<?=$menus?>>
                                        <input type='hidden' name='cm_category' value=<?=$cm_category?>>
                                        <input type='hidden' name='num' value=<?=$view_num?>>
                                        <button type='submit'>수정</button>
                                </form>
                                <form action='../section/community/view_del.php' method='post'>
                                        <input type='hidden' name='category' value=<?=$a?>>
                                        <input type='hidden' name='menu' value=<?=$menus?>>
                                        <input type='hidden' name='num' value=<?=$view_num?>>
                                        <button>삭제</button>
                                </form>
                                <?php
                        }
                }?>
        </div>
</div>
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
                                                <a href='../section/community/ripple_del.php?view_num=<?=$view_num?>&category=<?=$a?>&menu=<?=$menus?>&num=<?=$ripple_num?>'>[삭제]</a>
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
        <form action='../section/community/insert_ripple.php' method='post'>
        <table>
                <tr>
                        <th>댓글</th>
                        <td>
                                <input type='hidden' name='category' value=<?=$a?>>
                                <input type='hidden' name='menu' value=<?=$menus?>>
                                <input type='hidden' name='num' value=<?=$view_num?>>
                                <textarea name="ripple_content" rows="6" cols="100"></textarea></td>
                                <button type='submit' id='ripple_btn'>등록</button>
                        </td>
                </tr>
        </table>
        </form>
</div>
<div id='bottom'> </div>