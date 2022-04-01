<?php
$conn = new mysqli('localhost', 'root', 'LovelY-Su', 'member', '3306');
mysqli_query($conn, "set names utf8");

session_start(); 

if(!isset($_SESSION["userid"])) {
    echo "<script>alert('로그인 후 이용해 주세요.'); history.back();</script>";
}

$id = $_SESSION['userid'];

//htmlspecialchars 이름이랑 닉네임 태크 불가능하게 하기, ENT_QUOTES는 ""이것의 경우도 char형으로 변형
$hp = $_POST['hp1'].'-'.$_POST['hp2'].'-'.$_POST['hp3'];
$email = $_POST['email1'].'@'.$_POST['email2'];
$address1 = $_POST['address1'];
$address2 = $_POST['address2'];
$zipcode = $_POST['post'];

if (!$hp||!$address1||!$address2||!$zipcode||!$email){
    echo "<script>alert('필수항목을 모두 작성해주세요.'); history.back();</script>";
} else{

    $sql = "UPDATE member SET mem_email = '$email', mem_phone = '$hp', mem_address1 = '$address1', mem_address2 = '$address2', mem_zipcode = '$zipcode' WHERE mem_userid = '$id'";
    mysqli_query($conn, $sql);

    echo "<script>window.alert('정보 수정이 완료되었습니다.')</script>";
    echo "<meta http-equiv='refresh' content='0; url=../../index.php'>";
}

?>