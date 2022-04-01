<?php
$conn = new mysqli('localhost', 'root', 'LovelY-Su', 'member', '3306');
mysqli_query($conn, "set names utf8");

$view_num=$_GET['view_num'];

$sql_user_info = "SELECT * FROM goods WHERE num='$view_num'";

$result_user_info = mysqli_query($conn, $sql_user_info);
foreach($result_user_info as $user){

    $title=$user['subject'];
    $nickname=$user['nick'];
    $item_date = $user["regist_day"];
    //$item_date = substr($item_date,0,10);
    $content=$user['content'];
    $image_name_[0]=$user['file_name_0'];
    $image_name_[1]=$user['file_name_1'];
    $image_name_[2]=$user['file_name_2'];
    $image_name_[3]=$user['file_name_3'];
    $image_name_[4]=$user['file_name_4'];
    $image_copied_[0]=$user['file_copied_0'];
    $image_copied_[1]=$user['file_copied_1'];
    $image_copied_[2]=$user['file_copied_2'];
    $image_copied_[3]=$user['file_copied_3'];
    $image_copied_[4]=$user['file_copied_4'];

    $item_num=$user["num"];
    $item_time=$user["goods_time"];
    $item_price=$user["goods_price"];
    $item_complete=$user["complete"];
    $item_model=$user['model'];
    $item_brand=$user['brand'];
    $item_term=$user['term'];
    $item_rating=$user['goods_rating'];
    $name=$user['name'];

    $type=$user['sns_type'];
    $bidder_id=$user['bidder_id'];
    $user_id=$user['id'];
    $phone1=$user['phone'];

    $my_type=$user['my_sns_type'];

}

if(isset($item_complete)){
    if(!strcmp($item_complete, 'ing')){
            
            $title1='낙찰 완료하였습니다.';
            //$phone=$_SESSION['phone'];
            $content1='('.$title.')  낙찰 완료되었습니다.'.'<br>'.'판매자 연락처 : '.$phone1;
            
            $sql = "INSERT INTO note (from_nick, to_id, name, nick, title, content, regist_day, sns_type) VALUES ('관리자', '$bidder_id', '$name', '$nickname', '$title1', '$content1', now(), '$type')";
            mysqli_query($conn, $sql);

            //$s_id=$_SESSION['userid'];
            $s_nick=$_SESSION['nickname'];
            $s_name=$_SESSION['username'];
            $title2='등록하신 경매가 종료되었습니다.';
            $phone=$_SESSION['phone'];
            $content2='('.$title.')  낙찰 완료되었습니다.'.'<br>'.'구매자 연락처 : '.$phone;

            $sql = "INSERT INTO note (from_nick, to_id, name, nick, title, content, regist_day, sns_type) VALUES ('관리자', '$user_id', '$s_name', '$s_nick', '$title2', '$content2', now(), '$my_type')";
            mysqli_query($conn, $sql);
            

            //echo "<script>db_save()</script>";
    }
}

mysqli_query($conn,"UPDATE goods SET complete='end' WHERE num=$view_num");
?>