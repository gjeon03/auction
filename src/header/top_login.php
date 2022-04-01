<?php
$num =0;
if(isset($_SESSION['userid'])){
    $id=$_SESSION['userid'];
    $note_sns=$_SESSION['sns_type'];

    $conn = new mysqli('localhost', 'root', 'LovelY-Su', 'member', '3306');
    mysqli_query($conn, "set names utf8");

    $sql = "SELECT * FROM note WHERE to_id='$id' AND sns_type='$note_sns'";   

    //$sql = "SELECT * FROM free ORDER BY num DESC LIMIT $s_point, $list";
    $real_data = mysqli_query($conn, $sql);

    $num = mysqli_num_rows($real_data);
}
/*echo '아이디 : '.$_SESSION['userid'];

    echo '아이디 : '.$_SESSION['username'];
    echo '아이디 : '.$_SESSION['nickname'];
    echo '아이디 : '.$_SESSION['sns_type'];
    echo '아이디 : '.$_SESSION['phone'];
*/
?>
<div id="logo"><a href="../index.php" style="font-size:50px;">중고 경매</a></div>
<div id="top_login">
    <?php
    if(isset($_COOKIE['user_id_cookie'])&&isset($_COOKIE['user_hash_cookie'])){
        $id=$_COOKIE['user_id_cookie'];
        
        //echo "<script>location.href='../section/login/loginok.php';</script>";
        //echo "<script>ifrm1.location.href='../section/login/loginok.php';</script>"; 
        //echo "확인1";
        //require("../section/login/_conn.php");
        require ("/usr/local/apache2.4/htdocs/section/login/_conn.php");

        $sql_user_info = "SELECT * FROM member WHERE mem_userid='$id'";

        $result_user_info = mysqli_query($conn, $sql_user_info);
        foreach($result_user_info as $user){

            $username=$user['mem_username'];
            $nickname=$user['mem_nickname'];

            $sns_type=$user['sns_type'];

            $phone=$user['mem_phone'];
        }
        $_SESSION['userid'] = $id;

        $_SESSION['username'] = $username;
        $_SESSION['nickname'] = $nickname;
        $_SESSION['sns_type'] = $sns_type;
        $_SESSION['phone'] = $phone;
    }?>
    <?php
    if(!isset($_SESSION['userid'])) {
    ?>
        <a href="../feed/login_form.php">로그인</a> |
        <a href="../feed/join_form.php">회원가입</a>
    <?php
    } else {
    ?>
        <?php echo $_SESSION['nickname'];?> |
        <a onclick=note() id='note'>쪽지(<?=$num?>)</a> |
        <a href="../section/login/logout.php">로그아웃</a> |
        <a href="../feed/modified_form.php">정보수정</a>
    <?php
    }
    ?>
</div>
<script>
    function note(){
        window.open('/header/note.php','note.php','width=600,height=600,top=100,left=100');
    }
</script>