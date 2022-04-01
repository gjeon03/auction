<?php
session_start();
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../css/main.css">
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
                        if(isset($_GET["writing"])){
                                include "../section/community/writing.php";
                        }else{
                                include "../section/community/view.php";
                        }
                        ?>
                </div>
                <div id='footer'>
                        <?php include "footer/footer.php"; ?>
                </div>
        </div>
    </body>
</html>

