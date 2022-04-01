<?php
session_start();
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <!--<link rel="stylesheet" type="text/css" href="../css/common.css">
        <link rel="stylesheet" type="text/css" href="../css/concert.css">-->
    </head>
    <body>
        <div id="wrap">
                <div id="header">
                        <?php include "../header/top_login.php"; ?>
                </div>
                <div id="menu">
                        <?php include "../nav/top_menu.php"; ?>
                </div>
                <div id="content">
                        <div id="col1">
                                <div id="left_menu">
                                        <?php include "../sidebar/store.php";?>
                                </div>
                        </div>
                        <div id="col2">
                                <div id="title"><h2>입찰</h2></div>
                                <div id="body">
                                        <?php include "../section/store/goods.php";?>
                                </div>
                        </div>
                        <div id="right">
                                <?php include "../wrap_sidebar/right.php"?>
                        </div>
                </div>
                <div id='footer'>
                        <?php include "footer/footer.php"; ?>
                </div>
        </div>
    </body>
</html>