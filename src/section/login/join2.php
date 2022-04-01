<?php
session_start();

require('_conn.php');
//include "_conn.php";

$id = $_POST['userid'];

$pws = '';
$pw = '';

$pwcs = '';
$pwc = '';
if(isset($_POST['pw'])){
    $pws = $_POST['pw'];
    $pw = md5($pws); //비밀번호 암호화

    $pwcs = $_POST['pwc'];
    $pwc = md5($pwcs); //비밀번호 확인 암호화
}

$username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
$nickname = htmlspecialchars($_POST['nickname'], ENT_QUOTES, 'UTF-8');
//htmlspecialchars 이름이랑 닉네임 태크 불가능하게 하기, ENT_QUOTES는 ""이것의 경우도 char형으로 변형
$hp = $_POST['hp1'].'-'.$_POST['hp2'].'-'.$_POST['hp3'];
$email = $_POST['email1'].'@'.$_POST['email2'];
$address1 = $_POST['address1'];
$address2 = $_POST['address2'];
$zipcode = $_POST['post'];

//아이디 중복 체크
//$row = $result->num_rows;

//$result = mysqli_query($conn, $sql);

//if (mysqli_num_rows($result) > 0) {
//$row = mysqli_num_rows($result);
//중복된 아이디가 하나라도 있다면 1 이상이 출력됨.

/*$sql = "INSERT INTO member SET mem_userid='$id',mem_password='$pw',mem_username='$username',mem_nickname='$nickname',mem_email='$email',mem_phone='$hp',mem_address1='$address1',mem_address2='$address2',mem_zipcode='$zipcode'";
$result = mysqli_query($conn, $sql);
if($result === false){
    echo mysqli_error($conn);
}
echo mysqli_error($conn);
*/
$sns_type = $_POST['sns_type'];

if(!strcmp($sns_type, 'normal')){

    $ids = $_POST['userid2'];
    $nicknames =$_POST['usernick2'];

    if($nickname!=$nicknames){
        echo "<script>alert('닉네임 중복확인 해주세요.'); history.back();</script>";
        //echo "<meta http-equiv='refresh' content='0; url=../../feed/join_form.php'>";
    } elseif($id!=$ids){
        echo "<script>alert('아이디 중복확인 해주세요.'); history.back();</script>";
        //echo "<meta http-equiv='refresh' content='0; url=../../feed/join_form.php'>";
    } elseif (!$id||!$pw||!$pwc||!$username||!$nickname||!$hp||!$address1||!$address2||!$zipcode||!$email){
        echo "<script>alert('필수항목을 모두 작성해주세요.'); history.back();</script>";
    } else if($pw!=$pwc){
        echo "<script>alert('비밀번호를 정확히 입력해주세요.'); history.back();</script>";
    } else{
    
        $sql = "INSERT INTO member(sns_type, mem_userid, mem_password, mem_username, mem_nickname, mem_email, mem_phone, mem_address1, mem_address2, mem_zipcode) VALUES ('$sns_type', '$id', '$pw', '$username', '$nickname', '$email', '$hp', '$address1', '$address2', '$zipcode')";
        mysqli_query($conn, $sql);
    
        echo "<script>window.alert('회원가입이 완료되었습니다.')</script>";
        //echo "<meta http-equiv='refresh' content='0; url=../../index.php'>";
    
        //$row = $result->num_rows;
    
        //$sns_type = 'normal';
    
        require 'loginok.php';
        
        //echo "<script>window.alert('로그인이 완료되었습니다.')</script>";
        echo "<meta http-equiv='refresh' content='0;url=../../index.php'>";
    }
}else{
    if(isset($_POST['access_token'])){
        $access_token=$_POST['access_token'];
    }

    $sql = "INSERT INTO member(sns_type, mem_userid, mem_password, mem_username, mem_nickname, mem_email, mem_phone, mem_address1, mem_address2, mem_zipcode, access_token) VALUES ('$sns_type', '$id', '$pw', '$username', '$nickname', '$email', '$hp', '$address1', '$address2', '$zipcode', '$access_token')";
    mysqli_query($conn, $sql);

    echo "<script>window.alert('로그인이 완료되었습니다.')</script>";
    
    require 'loginok.php';

    echo "<meta http-equiv='refresh' content='0; url=../../index.php'>";

    //$row = $result->num_rows;

    //$sns_type = 'normal';

    //echo $sql;
    
    //echo "<script>window.alert('로그인이 완료되었습니다.')</script>";
    //echo "<meta http-equiv='refresh' content='0;url=../../index.php'>";
}


/*$sql = "SELECT * FROM member";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
        echo "아이디: " . $row["mem_userid"]. "이름:"  . $row["mem_username"]. " 닉네임:" . $row["mem_nickname"]. "<br>";
        }
        }else{
        echo "테이블에 데이터가 없습니다.";
        }
        mysqli_close($conn);
*/
?>