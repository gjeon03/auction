<?php
session_start();
if(isset($_GET["number"])){
        $conn = new mysqli('localhost', 'root', 'LovelY-Su', 'member', '3306');
        mysqli_query($conn, "set names utf8");

        $view_num = $_GET['number'];

        $sql_user_info = "SELECT * FROM goods WHERE num='$view_num'";

        $result_user_info = mysqli_query($conn, $sql_user_info);
        foreach($result_user_info as $user){

                $item_num=$user["num"];
                $item_time=$user["goods_time"];
        }
}
?>
<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>

<SCRIPT type="text/javascript">

function reverse_counter(){

        var dates='<?=$item_time?>';

        today = new Date();
        d_day = new Date(dates);
        days = (d_day - today) / 1000 / 60 / 60 / 24;
        daysRound = Math.floor(days);
        hours = (d_day - today) / 1000 / 60 / 60 - (24 * daysRound);
        hoursRound = Math.floor(hours);
        minutes = (d_day - today) / 1000 /60 - (24 * 60 * daysRound) - (60 * hoursRound);
        minutesRound = Math.floor(minutes);
        seconds = (d_day - today) / 1000 - (24 * 60 * 60 * daysRound) - (60 * 60 * hoursRound) -
        (60 * minutesRound);
        secondsRound = Math.round(seconds);

        min = " : "
        hr = " : "
        dy = " : "

        full_time = daysRound + 
        dy + hoursRound + hr + minutesRound + min + secondsRound;

        if((d_day - today)<0){
                full_time = '00:00:00:00';
                document.counter.counter_box.value = full_time;
                        
        }else{
                document.counter.counter_box.value = full_time;
                newtime = window.setTimeout("reverse_counter();", 1000);
        }

        
}

</script>

<!DOCTYPE HTML>
<html>
        <head>
                <meta charset="utf-8">
        </head>
        <body onLoad="reverse_counter()">
                <div id='timer'>
                        <form name="counter">
                                <input type="text" name="counter_box" size="10" >
                        </form>
                </div>
                <style>
                        #timer input{
                                font-size:15px;
                                border:none;
                                border:0px;
                        }
                </style>
        </body>
</html>