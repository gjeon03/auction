<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/password_modified.css">
</head>

<body>
    <?php
    session_start();
    $id = $_SESSION['userid'];
    ?>
    <div id="content">
            <div id="section_title" >비밀번호 수정</div>
            <div class="login_section">
                <form action="password_check.php" method="POST">
                    <table>
                            <tr class="login_pw">
                                    <th>PW</th>
                                    <td><input type="password" name="userpw" class="form-control"  placeholder="PASSWORD"></td>
                            </tr>
                    </table>
                    <div class="modified_btn">
                            <button type="submit" name="login" id="btn">확인</button>
                    </div>
                </form>
            </div>
    </div>
</body>
</html>