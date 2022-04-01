<?php
session_start();
if(!isset($_SESSION['userid'])){
    echo "<script>window.alert('로그인 후 이용해주세요.'); history.back();</script>";
}else{

    $price=$_GET['bidding_money'];
    $num=$_GET['num'];
    $min=$_GET['min'];
    $min_id=$_GET['min_id'];
    $sns=$_GET['sns'];

    if($price<$min){
        echo "<script>window.alert('금액을 올바르게 입력해주세요.'); history.back();</script>";
    }else{
        $conn = new mysqli('localhost', 'root', 'LovelY-Su', 'member', '3306');
        mysqli_query($conn, "set names utf8");

        mysqli_query($conn,"UPDATE goods SET goods_price=$price, sns_type='$sns', bidder_id='$min_id' WHERE num=$num");

        echo "<meta http-equiv='refresh' content='0;url=../../feed/goods1.php?number=$num'>";
    }

    
}
?>