<?php session_start(); ?>

<meta charset="utf-8">

<?php

if(!isset($_SESSION["userid"])) {
    echo "<script>alert('로그인 후 이용해 주세요.');history.back();</script>";
}else{
    require('/usr/local/apache2.4/htdocs/section/community/_conn.php');
    //$conn = new mysqli('localhost', 'root', 'LovelY-Su', 'member', '3306');
    //mysqli_query($conn, "set names utf8");

    $parent = $_POST['num'];

    $id = $_SESSION['userid'];
    $name = $_SESSION['username']; 
    $nick = $_SESSION['nickname'];

    $content = $_POST['ripple_content'];

    //$menu=$_POST['menu'];
    //$category=$_POST['category'];

    if (!$content){
        echo "<script>alert('내용이 입력되었는지 확인해주세요.'); history.back();</script>";
    } else{

        $sql = "INSERT INTO goods_ripple (parent, id, name, nick, content, regist_day) VALUES ('$parent', '$id', '$name', '$nick', '$content', now())";
        mysqli_query($conn, $sql);
        echo "<meta http-equiv='refresh' content='0; url=../../feed/goods1.php?number=$parent'>";
        //echo "<script>window.alert('글 작성이 완료되었습니다.')</script>";

        
    }
}
?>