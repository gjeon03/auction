<?php
session_start();

if(!isset($_SESSION["userid"])&&!isset($_SESSION["username"])&&!isset($_SESSION["nickname"])) {

?>
    <script>
    alert('로그인 후 이용해 주세요.');
    history.back();
    </script>
<?php
}

$conn = new mysqli('localhost', 'root', 'LovelY-Su', 'member', '3306');
mysqli_query($conn, "set names utf8");

//(mem_userid, mem_password, mem_username, mem_nickname, mem_email, mem_phone, mem_address1, mem_address2, mem_zipcode)
$session_id = $_SESSION["userid"];
$session_name = $_SESSION['username']; 
$session_nick = $_SESSION['nickname'];

$sql_user_info = "SELECT * FROM member WHERE mem_userid='$session_id'";

$result_user_info = mysqli_query($conn, $sql_user_info);
foreach($result_user_info as $user){

        $email1=$user['mem_email'];
        $phone1=$user['mem_phone'];
        $address1 = $user["mem_address1"];
        $address2=$user['mem_address2'];
        $zipcode=$user['mem_zipcode'];

        $sns_type=$user['sns_type'];

        $phones=explode("-", $phone1);
        $email=explode("@", $email1);

        $normal='normal';
        if($sns_type===$normal){
            $disabled='';
            $type='비밀번호 수정하기';
        }else{
            $disabled='disabled';
            $type='소셜 로그인';
            $session_id=$sns_type;
        }
}

//mysqli_query($conn,"UPDATE free SET hit = $hit WHERE num = $view_num");

?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../css/main.css">
        <link rel="stylesheet" type="text/css" href="../css/modified.css">
    </head>
    <body>
        <div id="wrap">
            <div id="header">
                    <?php include "../header/top_login.php"; ?>
            </div>
            <div id="menu">
                    <?php include "../nav/top_menu.php"; ?>
            </div>
            <div id="content">
                <div id="section_title" >회원정보 수정</div>
                <div id="form_modified">
                    <form id='modified_form' name="member_form" method="post" action="../modified/member.php">                
                        <div id="form_modified1">
                            <div id="modified1">
                                <ul>
                                    <li>* 아이디</li>
                                    <li>* 비밀번호</li>
                                    <li>* 이름</li>
                                    <li>* 닉네임</li>
                                    <li>* 휴대폰</li>
                                    <li>* 이메일</li>
                                    <div id="ad"><li>* 주소</li></div>
                                </ul>
                            </div>
                            <div id="modified2">
                                <ul>
                                    <li>
                                        <div id="id1"><?=$session_id?></div>
                                    </li>
                                    <li><input type="button" value="<?=$type?>" onclick=password() <?=$disabled?>></li>
                                    <li><div id="username"><?=$session_name?></div></li>
                                    <li>
                                        <div id="nick1"><?=$session_nick?></div>                            
                                    </li>
                                    <li>
                                        <input type="text" class="hp" name="hp1" value="<?=$phones[0]?>">
                                        - <input type="text" class="hp" name="hp2" value="<?=$phones[1]?>"> -
                                        <input type="text" class="hp" name="hp3" value="<?=$phones[2]?>">
                                    </li>
                                    <li>
                                        <input type="text" id="email1" name="email1" value="<?=$email[0]?>"> @
                                        <input type="text" name="email2" value="<?=$email[1]?>">
                                    </li>
                                    <li>
                                        <input type="text" name="post" id="post" value="<?=$zipcode?>" >
                                        <input type="button" onclick="execDaumPostcode()" value="주소 수정하기">
                                        <div id="address_tx1"><input type="text" id="address1" name="address1" value="<?=$address1?>" readonly></div>
                                        <div id="address_tx2"><input type="text" id="address2" name="address2" value="<?=$address2?>" ></div>
                                    </li>                     
                                </ul>
                            </div>
                        </div>
                        <div id="modified_btn">
                            <button type="submit">수정하기</button>
                        </div>
                    </form>
                    <div id="del_btn">
                        <button ><a href='../modified/del.php'>회원 탈퇴</a></button>
                    </div>
                </div>
            </div>
            <div id='footer'>
                    <?php include "footer/footer.php"; ?>
            </div>
        </div>
    <iframe src="" id="ifrm1" scrolling="no" frameborder="no" width="0" height="0" name="ifrm1"></iframe>
    <script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <script>
        function execDaumPostcode() {
            new daum.Postcode({
                oncomplete: function(data) {
                    // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                    // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                    // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                    var addr = ''; // 주소 변수
                    var extraAddr = ''; // 참고항목 변수

                    //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                    if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                        addr = data.roadAddress;
                    } else { // 사용자가 지번 주소를 선택했을 경우(J)
                        addr = data.jibunAddress;
                    }

                    // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
                    if(data.userSelectedType === 'R'){
                        // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                        // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                        if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                            extraAddr += data.bname;
                        }
                        // 건물명이 있고, 공동주택일 경우 추가한다.
                        if(data.buildingName !== '' && data.apartment === 'Y'){
                            extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                        }
                        // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                        if(extraAddr !== ''){
                            extraAddr = ' (' + extraAddr + ')';
                        }
                        // 조합된 참고항목을 해당 필드에 넣는다.
                        //document.getElementById("sample6_extraAddress").value = extraAddr;
                    
                    }

                    // 우편번호와 주소 정보를 해당 필드에 넣는다.
                    document.getElementById('post').value = data.zonecode;
                    document.getElementById("address1").value = addr;
                    // 커서를 상세주소 필드로 이동한다.
                    document.getElementById("address2").focus();
                }
            }).open();
        }
    </script>
    <script>
        function password(){
            window.open('../modified/password_modified.php','password_modified.php','width=600,height=600,top=100,left=100');
        }
    </script>
    </body>
</html>