<?php
/*if(isset($access_token)){
    $sql = "UPDATE member SET access_token = '$access_token' WHERE mem_userid = '$id'";
    mysqli_query($conn, $sql);
}*/

if(isset($_COOKIE['user_id_cookie'])&&isset($_COOKIE['user_hash_cookie'])){
    $id=$_COOKIE['user_id_cookie'];
}

$sql_user_info = "SELECT * FROM member WHERE sns_type='$sns_type' AND mem_userid='$id'";
//echo $sql_user_info.'<br>';
$result_user_info = mysqli_query($conn, $sql_user_info);
foreach($result_user_info as $user){

    $username=$user['mem_username'];
    $nickname=$user['mem_nickname'];

    $sns_type=$user['sns_type'];

    $phone=$user['mem_phone'];

    //echo $username.'<br>';
}
$_SESSION['userid'] = $id;

$_SESSION['username'] = $username;
$_SESSION['nickname'] = $nickname;
$_SESSION['sns_type'] = $sns_type;
$_SESSION['phone'] = $phone;
?>