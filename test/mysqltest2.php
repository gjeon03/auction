<?php
$db_conn = new mysqli("localhost", "root", "LovelY-Su", "member", "3306");
if (!$db_conn) {
    $error = mysqli_connect_error();
    $errno = mysqli_connect_errno();
    print "$errno: $error\n";
    exit();
}else{
        echo "DB 연결 성공<p>";

}
mysqli_close($db_conn);
?>
