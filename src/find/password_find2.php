<?php
$conn = new mysqli('localhost', 'root', 'LovelY-Su', 'member', '3306');
mysqli_query($conn, "set names utf8");

$id = $_POST['userid'];
$email=$_POST['email1']."@".$_POST['email2'];
 
$sql_user_info = "SELECT * FROM member WHERE mem_email='$email' AND mem_userid='$id'";

$result_user_info = mysqli_query($conn, $sql_user_info);

if (mysqli_num_rows($result_user_info) > 0) {
    $str = 'abcdefghijklmnopqrstuvwxyz0123456789!@#$%&*ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $max = strlen($str) - 1;
    $chr = '';
    //$len = abs(10);

    for($i=0; $i<12; $i++) {
        $chr .= $str[random_int(0, $max)];
    }

    $pw = md5($chr); //비밀번호 암호화

    mysqli_query($conn,"UPDATE member SET mem_password = '$pw' WHERE mem_userid = '$id'");
    
    require ('email_pw.php');

}else{
    echo "<script>parent.alert('가입 정보를 제대로 입력해주세요.');</script>";
    echo "<meta http-equiv='refresh' content='0; url=password_find.php'>";
}

?>