<?php
session_start();
$conn = new mysqli('localhost', 'root', 'LovelY-Su', 'member', '3306');
mysqli_query($conn, "set names utf8");

$id = $_SESSION['userid'];
$pws = $_POST['userpw'];
$pw = md5($pws);

$sql = "SELECT * FROM member WHERE mem_userid='$id' AND mem_password='$pw'";
$result = mysqli_query($conn, $sql);

//$row = $result->num_rows;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/password_modified.css">
</head>

<body>
    <div id="content">
            <div id="section_title" >비밀번호 수정</div>
            <div class="login_section">
                <?php
                if(mysqli_num_rows($result) > 0){
                    ?>
                    <form action="password_complete.php" method="POST">
                        <input type='hidden' id="userid" name='userid' value="<?=$id?>">
                        <table>
                                <tr class="login_pw">
                                        <th>PW</th>
                                        <td><input type="password" name="userpw" class="form_control"  placeholder="PASSWORD"></td>
                                </tr>
                                <tr class="login_pw">
                                        <th>확인</th>
                                        <td><input type="password" name="userpw2" class="form_control2"  placeholder="PASSWORD"></td>
                                </tr>
                        </table>
                        <div class="modified_btn">
                            <button type="submit" name="login" id="btn">확인</button>
                        </div>
                    </form>
                    <?php
                }else{
                    echo "<script>window.alert('비밀번호를 확인하세요.')</script>";
                    echo "<script>history.back();</script>";
                }
                ?>
            </div>
    </div>
</body>
</html>