<?php
session_start();

if(!isset($_COOKIE['cookie_popup'])){
        echo "<script>window.open('cookie_window/window.php','window.php','width=600,height=600,top=100,left=100');</script>";
}
//setcookie("cookie_popup", "", time()-3600,"/");
//setcookie('goods_today_view', '', time() - 86400, "/");
//setcookie('text_today_view', '', time() - 86400, "/");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
</head>

<body>
        <div id="wrap">
                <div id="header">
                        <?php include "header/top_login.php"; ?>
                </div>
                <div id="menu">
                        <?php include "nav/top_menu.php"; ?>
                </div>
                <div id="content">
                        <div id="main_img"><img src="../img/auction.jpg"></div>
                </div>
                <div id='footer'>
                        <?php include "footer/footer.php"; ?>
                </div>
        </div> 
</body>
</html>
