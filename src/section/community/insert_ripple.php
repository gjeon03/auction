<?php session_start(); ?>

<meta charset="utf-8">

<?php

if(!isset($_SESSION["userid"])) {
?>

<script>
alert('로그인 후 이용해 주세요.');
history.back();
</script>

<?php
}
require('/usr/local/apache2.4/htdocs/section/community/_conn.php');
//$conn = new mysqli('localhost', 'root', 'LovelY-Su', 'member', '3306');
//mysqli_query($conn, "set names utf8");

$parent = $_POST['num'];

$id = $_SESSION['userid'];
$name = $_SESSION['username']; 
$nick = $_SESSION['nickname'];

$type=$_SESSION['sns_type'];

$content = $_POST['ripple_content'];

$menu=$_POST['menu'];
$category=$_POST['category'];

if (!$content){
    echo "<script>alert('내용이 입력되었는지 확인해주세요.'); history.back();</script>";
} else{

    //echo "<script>window.alert('글 작성이 완료되었습니다.')</script>";

    if(!strcmp($menu, "community:")){
        $sql = "INSERT INTO free_ripple (parent, id, name, nick, content, regist_day) VALUES ('$parent', '$id', '$name', '$nick', '$content', now())";
        mysqli_query($conn, $sql);
        echo "<meta http-equiv='refresh' content='0; url=../../feed/community_form.php?category=$category&community_view=$parent'>";
    }
    if(!strcmp($menu, "notice:")){
        $sql = "INSERT INTO notice_ripple (parent, id, name, nick, content, regist_day) VALUES ('$parent', '$id', '$name', '$nick', '$content', now())";
        mysqli_query($conn, $sql);
        echo "<meta http-equiv='refresh' content='0; url=../../feed/service_center_form.php?notice_view=$parent'>";
    }
    if(!strcmp($menu, "question:")){
        if(!strcmp($id,'jeon')){

            $conn = new mysqli('localhost', 'root', 'LovelY-Su', 'member', '3306');
            mysqli_query($conn, "set names utf8");


            $sql_user_info = "SELECT * FROM question WHERE num='$parent'";

            $result_user_info = mysqli_query($conn, $sql_user_info);
            foreach($result_user_info as $user){
                $y_id=$user["id"];
                $y_nick=$user["nick"];
                $y_name=$user["name"];
                $y_sns=$user["sns_type"];
            }

            $title1='문의 사항에 답글이 달렸습니다.';
            //$phone=$_SESSION['phone'];
            $content1='문의 사항을 확인해 주세요.';
            
            $sql = "INSERT INTO note (from_nick, to_id, name, nick, title, content, regist_day, sns_type) VALUES ('관리자', '$y_id', '$y_name', '$y_nick', '$title1', '$content1', now(), '$y_sns')";
            mysqli_query($conn, $sql);

            $sql = "UPDATE question SET complete='end' WHERE id = '$y_id'";
            mysqli_query($conn, $sql);
        }
        $sql = "INSERT INTO question_ripple (parent, id, name, nick, content, regist_day) VALUES ('$parent', '$id', '$name', '$nick', '$content', now())";
        mysqli_query($conn, $sql);
        echo "<meta http-equiv='refresh' content='0; url=../../feed/service_center_form.php?question_view=$parent'>";
    }
}
?>