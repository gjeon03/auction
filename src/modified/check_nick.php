<?php
$conn = new mysqli('localhost', 'root', 'LovelY-Su', 'member', '3306');
mysqli_query($conn, "set names utf8");

$nick=$_GET['usernick'];
 
$sql="SELECT * FROM member WHERE mem_nickname='$nick'";
$result = mysqli_query($conn, $sql);
//$row=mysqli_num_rows($result);

if (mysqli_num_rows($result) > 0) {
    echo "<script>parent.document.getElementById('usernick2').value='';</script>";
    echo "<script>parent.alert('이미 사용중인 닉네임입니다.');</script>";
}else{
    echo "<script>parent.document.getElementById('usernick2').value='".$nick."';</script>";
    echo "<script>parent.alert('사용 가능한 닉네임 입니다.');</script>";
}
?>