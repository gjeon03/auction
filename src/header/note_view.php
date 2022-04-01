<?php
session_start();

$conn = new mysqli('localhost', 'root', 'LovelY-Su', 'member', '3306');
mysqli_query($conn, "set names utf8");

$view_num = $_GET['note_view'];

$sql_user_info = "SELECT * FROM note WHERE num='$view_num'";

$result_user_info = mysqli_query($conn, $sql_user_info);
foreach($result_user_info as $user){

    $item_num=$user["num"];
    $note_from_nick=$user["from_nick"];
    $to_id=$user["to_id"];
    $note_name=$user["name"];
    $note_nick=$user["nick"];
    $note_title=$user["title"];
    $content=$user["content"];
    $note_date=$user["regist_day"];
    $note_date=substr($note_date, 0, 10);
    $note_sns_type=$user["sns_type"];
}
?>
<link rel="stylesheet" type="text/css" href="../css/note_view.css">
<div id='note_view'>
    <div id="section_title" style="font-size:20px">쪽지</div>
    <div id="view">
        <div id="view_top">
            <div id="view_title">제목 : <?=$note_title?></div>
            <div id="nickname"><?=$note_from_nick?></div>
            <div id="community_date"><?=$note_date?></div>
        </div>
        <div id="view_main">
            <div id="community_contents">
                <?=$content?>
            </div>
        </div>
        <div id="view_bottom">
            <?php
            if(isset($_SESSION['userid'])){
                if((isset($_GET["note_view"])&&!strcmp($to_id, $_SESSION['userid']))||!strcmp($_SESSION['userid'], 'jeon')){
                    ?>
                    <form action='note_del.php' method='post' id='del_btn'>
                        <input type='hidden' name='num[]' value=<?=$item_num?>>
                        <input type='hidden' name='del' value="ing">
                        <button id='del_btn'>삭제</button>
                    </form>
                    <form class="writing" action="note.php" method="get">
                        <button type="submit" name="writing" value="ing">목록</button> 
                    </form>
                    <?php
                }
            }?>
        </div>
    </div>
</div>