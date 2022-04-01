<?php
session_start();

if(!isset($_POST['del'])){
    echo "<script>alert('잘못된 경로로 접속하셨습니다.'); history.back();</script>";
}else{
    $conn = new mysqli('localhost', 'root', 'LovelY-Su', 'member', '3306');
    mysqli_query($conn, "set names utf8");

    $id=$_SESSION['userid'];
    $sns_type='';

    $note_num=$_POST['num'];

    $count= count($note_num);
    
    if(isset($_POST['num'])){
        
        for($i=0; $i<$count; $i++){
            $sql = "DELETE FROM note WHERE num='$note_num[$i]'";
            $result= mysqli_query($conn, $sql);
        }
    }

    echo "<script>alert('삭제 하였습니다.');</script>";

    echo "<meta http-equiv='refresh' content='0;url=note.php'>";
    //require '../section/login/logout.php';
}

?>