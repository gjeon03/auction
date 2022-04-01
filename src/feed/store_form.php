<?php
session_start();
?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../css/main.css">
        <link rel="stylesheet" type="text/css" href="../css/store_section1.css">
    </head>
    <body >
        <div id="wrap">
                <div id="header">
                        <?php include "../header/top_login.php"; ?>
                </div>
                <div id="menu">
                        <?php include "../nav/top_menu.php"; ?>
                </div>
                <div id="content">
                        <?php 
                        if(!isset($_GET["number"])){
                        ?>
                        <div id="sidebar">
                                <div id="left_menu">
                                        <?php include "../sidebar/store.php";?>
                                </div>
                        </div>
                        <div id="section">
                                <?php 
                                include "../section/store/exhibition.php";
                                ?>
                        </div>
                        <?php
                        }else{
                                ?>
                                <div id="section">
                                        <?php
                                        include "../section/store/goods.php";
                                        ?>
                                </div>
                                <?php
                        }
                        ?>
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