<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../css/find.css">
    </head>
    <body>
        <div id="content">
            <div id="section_title" >아이디 찾기</div>
            <div class="login_section">
                <form action="id_find2.php" method="POST">
                    <table>                            
                        <tr>
                            <th>가입한 이메일</th>
                            <td>
                                <input type="text" name="email1" placeholder="이메일">@
                                <input type="text" name="email2" placeholder="주소">
                            </td>
                        </tr>
                    </table>
                    <div class="login_btn">
                        <input type="submit" name="login" value="이메일로 아이디 보내기">
                    </div>
                </form>                                
            </div>
        </div>
    </body>
</html>