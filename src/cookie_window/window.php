<script>
    function win_close(){

        <?php
        //if() 
          //setcookie('popup_cookie', 1, time() + 3600*24, "/"); ?>

        window.close();
    }
</script>
<?php

$title = "사기주의!!!";
$popup_body ="안녕하세요.<br> 코로나로 인해 비대면 거래량이 많아져 사기가 기승을 부리고 있습니다.... ";

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/popup.css">
</head>

<body>
    <div>
        <div id="popup_body">
            <div id='title'> <?=$title?></div>
            <div id='body'><?=$popup_body?></div>
        </div>
        <div id="popup_bottom">
            <form action="popup_cookie.php" method="POST">
                <div class="cookie_popup1"><input type="checkbox" name="cookie_popup" value="1"> 24시간 동안 표시 안하기</div>
                <div class="cookie_popup2"><input type="submit" value="창닫기" ></div>
            </form>
        </div>
    </div>
</body>
</html>
