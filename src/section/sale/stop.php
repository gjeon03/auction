<div id='title'>경매 중지시 재시작은 불가능합니다. 중지 하겠습니까?</div>
<div id='button'>
    <input type="button" value="중지" onclick=stop()>
</div>

<style>
    #title{
        padding:20px;
    }
    #button{
        margin-left:160px;
    }
    input{
        width:100px;
        height:30px;
    }
</style>

<SCRIPT type="text/javascript">
function stop(){
    <?php
    $conn = new mysqli('localhost', 'root', 'LovelY-Su', 'member', '3306');
    mysqli_query($conn, "set names utf8");

    $view_num = $_GET['num'];
    
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

    $title1='낙찰이 판매자에 의해 중지되었습니다.';
    //$phone=$_SESSION['phone'];
    $content1='('.$title.')  낙찰이 판매자에 의해 중지었습니다.';
    //'관리자', '$to_id', '$name', '$nickname', '$title1', '$content1', now(), '$type
    if(isset($bidder_id)){
        $sql = "INSERT INTO note (from_nick, to_id, name, nick, title, content, regist_day, sns_type) VALUES ('관리자', '$bidder_id', '$name', '$nickname', '$title1', '$content1', now(), '$type')";
        mysqli_query($conn, $sql);
    }
    
    $timestamp = strtotime("-1 days");
    $auction_date = date("Y-m-d H:i:s", $timestamp);

    mysqli_query($conn,"UPDATE goods SET complete='stop', goods_time='$auction_date' WHERE num=$view_num");
    //echo $sql;
    ?> 

    opener.document.location.reload();
    self.close();
}
</script>