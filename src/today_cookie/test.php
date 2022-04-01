<?php
for($i=0; $i<count($tod); $i++){
		if($i==0){
			setcookie('text_today_view', $tod[$i], time() + 3600*24, "/");
		}else{
			$todayview=$_COOKIE['text_today_view'];
		}
		setcookie('text_today_view', $todayview.",".$tod[$i], time() + 3600*24, "/");
    }
    ?>