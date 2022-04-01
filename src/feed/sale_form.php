<?php
session_start();
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../css/main.css">
        <link rel="stylesheet" type="text/css" href="../css/sale_section1.css">
        <link rel="stylesheet" type="text/css" href="../css/sale_section2.css">
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
                        <div id="sidebar">
                                <div id="left_menu">
                                        <?php include "../sidebar/sale.php";?>
                                </div>
                        </div>                
                        <div id="section">
                        <?php 
                                if(isset($_GET["enrollment"])){
                                        include "../section/sale/sale_enrollment.php"; 
                                }else{
                                        include "../section/sale/enrollment_status.php";
                                }
                                ?>
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