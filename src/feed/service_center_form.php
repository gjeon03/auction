<?php
session_start();

?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../css/main.css">
        <link rel="stylesheet" type="text/css" href="../css/service_center_section1.css">
        <link rel="stylesheet" type="text/css" href="../css/service_center_section2.css">
        <link rel="stylesheet" type="text/css" href="../css/community_section2.css">
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
                        <?php 
                        if(!isset($_GET["number"])){
                        ?>
                        <div id="sidebar">
                                <div id="left_menu">
                                        <?php include "../sidebar/service_center.php";?>
                                </div>
                        </div>
                        <?php
                        }
                        ?>
                        <div id="section">
                                <?php
                                if(!isset($_POST['notice_writing'])){
                                        if(isset($_GET['category'])){
                                                $ca = $_GET['category'];
                                        }else {
                                                $ca = "";
                                        }
                                        if(isset($_GET["notice_view"])||isset($_GET["question_view"])){
                                                include "../section/community/view.php";
                                        } elseif(isset($_GET["write"])){
                                                include "../section/service_center/questions.php";
                                        } elseif(!strcmp($ca,"status")){
                                                include "../section/service_center/inquire.php";
                                        } else{                                
                                                include "../section/service_center/notice.php";
                                        }
                                }else {
                                        include "../section/service_center/notice_writing.php";
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