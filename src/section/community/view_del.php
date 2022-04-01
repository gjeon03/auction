<?php
session_start();
if(!isset($_SESSION["userid"])) {
?>

<script>
alert('로그인 후 이용해 주세요.');
history.back();
</script>

<?php
}

$view_num=$_POST['num'];
$menu=$_POST['menu'];
$category=$_POST['category'];
//$view_num=$_POST['view_num'];

$conn = new mysqli('localhost', 'root', 'LovelY-Su', 'member', '3306');
mysqli_query($conn, "set names utf8");

if(!strcmp($menu, "community:")){
    $sql = "DELETE FROM free WHERE num='$view_num'";
    $result= mysqli_query($conn, $sql);
    echo "<meta http-equiv='refresh' content='0; url=../../feed/community_form.php'>";
}
if(!strcmp($menu, "notice:")){
    $sql = "DELETE FROM notice WHERE num='$view_num'";
    $result= mysqli_query($conn, $sql);
    echo "<meta http-equiv='refresh' content='0; url=../../feed/service_center_form.php'>";
}
if(!strcmp($menu, "question:")){
    $sql = "DELETE FROM question WHERE num='$view_num'";
    $result= mysqli_query($conn, $sql);
    echo "<meta http-equiv='refresh' content='0; url=../../feed/service_center_form.php'>";
}

?>