<?php
session_start();
require '_conn.php';

$id = $_POST['userid'];

$pws = $_POST['userpw'];
$pw = md5($pws);

$sql = "SELECT * FROM member WHERE mem_userid='$id' AND mem_password='$pw'";
$result = mysqli_query($conn, $sql);

//$row = $result->num_rows;

$sns_type = 'normal';

if(mysqli_num_rows($result) > 0){

    require 'loginok.php';

    if(isset($_POST['cookie'])){
        $master_key = "jeon";
        $id;
        $pws;
        $hash = md5($master_key.$pws);
        
        //require 'set_cookie.php';
        
        setcookie("user_id_cookie", $id, time()+3600*24*7,"/");
        setcookie("user_hash_cookie", $hash, time()+3600*24*7,"/");
        
        /*echo "<script>location.href = 'set_cookie.php?id=<?=$id?>&hash=<?=$hash?>';</script>";
        */
    }

    /*
    echo '아이디 : '.$_SESSION['userid'];
    echo '아이디 : '.$_SESSION['username'];
    echo '아이디 : '.$_SESSION['nickname'];
    echo '아이디 : '.$_SESSION['sns_type'];
    echo '아이디 : '.$_SESSION['phone'];
    */

    echo "<script>window.alert('로그인이 완료되었습니다.')</script>";
    echo "<meta http-equiv='refresh' content='0;url=../../index.php'>";
    //echo "<meta http-equiv='refresh' content='0;url=../../index.php'>";
    //exit;
}else{
    echo "<script>window.alert('로그인에 실패하였습니다. 아이디와 비밀번호를 확인하세요.')</script>";
    echo "<meta http-equiv='refresh' content='0; url=../../feed/login_form.php'>";
}
?>