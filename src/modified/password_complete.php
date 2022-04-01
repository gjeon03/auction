<?php
$conn = new mysqli('localhost', 'root', 'LovelY-Su', 'member', '3306');
mysqli_query($conn, "set names utf8");

$id = $_POST['userid'];

$pws = $_POST['userpw'];
$pw = md5($pws); //비밀번호 암호화

$pwcs = $_POST['userpw2'];
$pwc = md5($pwcs); //비밀번호 확인 암호화

$password="";

$sql_user_info = "SELECT * FROM member WHERE mem_userid='$id'";

$result_user_info = mysqli_query($conn, $sql_user_info);
foreach($result_user_info as $user){
    $password=$user['mem_password'];
}
if($password==$pw){
    echo "<script>alert('이전 비밀번호랑 다르게 입력해주세요.'); </script>";
    echo "<meta http-equiv='refresh' content='0; url=password_modified.php'>";
}elseif($pw!=$pwc){
    echo "<script>alert('비밀번호를 정확히 입력해주세요.'); history.back();</script>";
}else{
    mysqli_query($conn,"UPDATE member SET mem_password = '$pw' WHERE mem_userid = '$id'");
    echo "<script>alert('변경 완료하였습니다.'); window.close();</script>";
}
?>