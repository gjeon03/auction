<?php
if(geaders_sent($file,$line)){
    echo "쿠키를 생성할 수 없습니다.";
} else{
    setcookie("user_id_cookie", $id, time()+3600*24*7,"/");
    setcookie("user_hash_cookie", $hash, time()+3600*24*7,"/"); 
}
?>