<?php
session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../css/main.css">
        <link rel="stylesheet" type="text/css" href="../css/login.css">
        <script type="text/javascript" src="https://static.nid.naver.com/js/naverLogin_implicit-1.0.3.js" charset="utf-8"></script>
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
</head>
<body>
        <?php
        if(!isset($_SESSION['userid'])){
                ?>
        <div id="wrap">
                <div id="header">
                        <?php include "../header/top_login.php"; ?>
                </div>
                <div id="menu">
                        <?php include "../nav/top_menu.php"; ?>
                </div>
                <div id="content">
                        <div id="section_title" >로그인</div>
                        <div class="login_section">
                                <div id=auc_login>
                                        <form action="../section/login/login2.php" method="POST">
                                                <table>                            
                                                        <tr>
                                                                <th>ID</th>
                                                                <td><input type="text" name="userid" class="form-control"  placeholder="ID"></td>
                                                        </tr>
                                                        <tr class="login_pw">
                                                                <th>PW</th>
                                                                <td><input type="password" name="userpw" class="form-control"  placeholder="PASSWORD"></td>
                                                        </tr>
                                                </table>
                                                <div class="cookie"><input type="checkbox" name="cookie" value="2"> 자동로그인</div>
                                                <div class="login_btn">
                                                        <input type="submit" name="login" value="LOGIN">
                                                </div>
                                        </form>                                
                                        <a onclick=id_find() id='id_find'>아이디 찾기</a> |
                                        <a onclick=password_find() id='password_find'>비밀번호 찾기</a>
                                </div>
                                <div id='sns'>
                                        <?php
                                        // 네이버 로그인 접근토큰 요청 예제
                                        $client_id = "ObhfZDRsKVUmWtQk8Z7R";
                                        $redirectURI = urlencode("https://192.168.136.130/section/login/naver_callback.php");
                                        $state = md5(microtime() . mt_rand());
                                        $_SESSION['naver_state'] = $state;
                                        $apiURL = "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=".$client_id."&redirect_uri=".$redirectURI."&state=".$state;
                                        ?><a href="<?php echo $apiURL ?>"><img width="220" height="40" src="../img/naver_green.PNG"/></a>
                                        <?php
                                        //kakao_login.php
                                        $restAPIKey = "70265c74fc52a7a20a2ead4c7de06482"; //본인의 REST API KEY를 입력해주세요
                                        $callbacURI = urlencode("https://192.168.136.130/section/login/kakao_callback.php"); //본인의 Call Back URL을 입력해주세요
                                        $state = md5(microtime() . mt_rand());
                                        $_SESSION['kakao_state'] = $state;
                                        $kakaoLoginUrl = "https://kauth.kakao.com/oauth/authorize?client_id=".$restAPIKey."&redirect_uri=".$callbacURI."&response_type=code&state=".$state;
                                        ?><a href="<?php echo $kakaoLoginUrl ?>"><img width="220" height="40" src="../img/kakao_login_medium_narrow.png"/></a>

                                        <?php
                                        require '../login_api/vendor/autoload.php' ;
                                        $fb = new  Facebook \ Facebook ([
                                                'app_id' => '372859457440225' ,
                                                'app_secret' => '79dc5f4973ceaf0e73137687dd12374e' ,
                                                'default_graph_version' => 'v2.10' ,
                                        ]);
                                        $helper = $fb->getRedirectLoginHelper();
                                        $permissions = ['email']; // optional
                                        $loginUrl = $helper->getLoginUrl('https://192.168.136.130/section/login/facebook_callback.php', $permissions);
                                        ?><a href="<?php echo $loginUrl ?>"><img width="220" height="40" src="../img/facebook_button1.png"/></a>
                                </div>
                        </div>
                </div>
        </div>
        <?php
        }
        ?>
        <script>
        function id_find(){
            window.open('../find/id_find.php','password_modified.php','width=600,height=600,top=100,left=100');
        }

        function password_find(){
            window.open('../find/password_find.php','password_modified.php','width=600,height=600,top=100,left=100');
        }
        </script>
    </body>
</html>
