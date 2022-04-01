<?php
session_start(); 
?>

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

$ripple_num=$_GET['num'];
$menu=$_GET['menu'];
$category=$_GET['category'];
$view_num=$_GET['view_num'];

$conn = new mysqli('localhost', 'root', 'LovelY-Su', 'member', '3306');
mysqli_query($conn, "set names utf8");

if(!strcmp($menu, "community:")){
    $sql = "DELETE FROM free_ripple WHERE num='$ripple_num'";
    $result= mysqli_query($conn, $sql);
    echo "<meta http-equiv='refresh' content='0; url=../../feed/community_form.php?category=$category&community_view=$view_num'>";
}
if(!strcmp($menu, "notice:")){
    $sql = "DELETE FROM notice_ripple WHERE num='$ripple_num'";
    $result= mysqli_query($conn, $sql);
    echo "<meta http-equiv='refresh' content='0; url=../../feed/service_center_form.php?notice_view=$view_num'>";
}
if(!strcmp($menu, "question:")){
    $sql = "DELETE FROM question_ripple WHERE num='$ripple_num'";
    $result= mysqli_query($conn, $sql);
    echo "<meta http-equiv='refresh' content='0; url=../../feed/service_center_form.php?question_view=$view_num'>";
}

?>