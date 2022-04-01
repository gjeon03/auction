<?php
$conn = new mysqli('localhost', 'root', 'LovelY-Su', 'member', '3306');
mysqli_query($conn, "set names utf8");

$email=$_POST['email1']."@".$_POST['email2'];
 
$sql_user_info = "SELECT * FROM member WHERE mem_email='$email'";

$result_user_info = mysqli_query($conn, $sql_user_info);

if (mysqli_num_rows($result_user_info) > 0) {
    foreach($result_user_info as $user){

        $userid=$user['mem_userid'];
    }
    
    require ('email_id.php');
    /*echo "<script>ifrm1.location.href='../section/login/check_id.php?userid='<?=$email?>;</script>";*/

    //echo "<script>parent.alert('이메일을 확인해주세요.');</script>";
    //echo "<script>window.close();</script>";
}else{
    echo "<script>parent.alert('가입자중 해당하는 이메일을 찾기 못했습니다.');</script>";
    echo "<meta http-equiv='refresh' content='0; url=id_find.php'>";
}

?>