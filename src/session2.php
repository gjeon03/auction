<?php 

session_start();

$id =session_id();
echo "session ID... ($id) <br />";
echo "세션에 등록된 내용<br />";

echo "car brand :". $_SESSION['device'] ."<br />";
echo "car color :". $_SESSION['color']."<br />";

echo $_SESSION['device'];
echo $_SESSION['device'] ."(닉네임 :". $_SESSION['color'];

?>