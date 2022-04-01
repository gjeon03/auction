<?php
session_start();
setcookie(session_name(), '', 100);
session_unset();
session_destroy();
$_SESSION = array();

if(isset($_COOKIE['user_id_cookie'])&&isset($_COOKIE['user_hash_cookie'])){
    setcookie("user_id_cookie", '', time(),"/");
    setcookie("user_hash_cookie", '', time(),"/");
}

echo "<script>alert('로그아웃 되었습니다.')</script>";
echo "<meta http-equiv='refresh' content='0;url=../../index.php'>";
?>