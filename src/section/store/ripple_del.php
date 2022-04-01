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

$view_num=$_GET['view_num'];

$conn = new mysqli('localhost', 'root', 'LovelY-Su', 'member', '3306');
mysqli_query($conn, "set names utf8");

$sql = "DELETE FROM goods_ripple WHERE num='$ripple_num'";
$result= mysqli_query($conn, $sql);
echo "<meta http-equiv='refresh' content='0; url=../../feed/goods1.php?number=$view_num'>";

?>