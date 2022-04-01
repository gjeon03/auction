<?php
if(isset($_POST['cookie_popup'])){
        //require 'set_cookie.php';
        $popup = $_POST['cookie_popup'];
        
        setcookie("cookie_popup", $popup, time()+3600*24,"/");
        
        /*echo "<script>location.href = 'set_cookie.php?id=<?=$id?>&hash=<?=$hash?>';</script>";
        */
        echo "<script>window.close();</script>";
}else {
    echo "<script>window.close();</script>";
}
?>