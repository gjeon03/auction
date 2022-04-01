<?php
require '_conn.php';

$id=$_GET['userid'];

$sns_type='normal';
 
$sql="SELECT * FROM member WHERE mem_userid='$id' AND sns_type='$sns_type'";
$result = mysqli_query($conn, $sql);
//$row=mysqli_num_rows($result);

if (mysqli_num_rows($result) > 0) {
    echo "<script>parent.document.getElementById('userid2').value='';</script>";
    echo "<script>parent.alert('이미 사용중인 아이디입니다.');</script>";
}else{
    echo "<script>parent.document.getElementById('userid2').value='".$id."';</script>";
    echo "<script>parent.alert('사용 가능한 아이디 입니다.');</script>";
}
?>