<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../css/find.css">
    </head>
    <body>
        <div id="content">
            <div id="section_title" >비밀번호 찾기</div>
            <div class="login_section">
                    <form action="password_find2.php" method="POST">
                            <table>                            
                                    <tr>
                                            <th>ID</th>
                                            <td><input type="text" name="userid" placeholder="ID"></td>
                                    </tr>
                                    <tr>
                                            <th>가입한 이메일</th>
                                            <td>
                                                <input type="text" name="email1" placeholder="이메일">@
                                                <input type="text" name="email2" placeholder="주소">
                                            </td>
                                    </tr>
                            </table>
                            <div class="login_btn">
                                    <input type="submit" name="login" value="이메일로 임시 비밀번호 보내기">
                            </div>
                    </form>
            </div>
        </div>
    </body>
</html>