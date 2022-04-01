<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="stylesheet" type="text/css" href="../css/join.css">
</head>
<body>
    <div id="wrap">
        <div id="header">
            <?php include "../header/top_login.php"; ?>
        </div> <!-- end of header -->
        
        <div id="menu">
            <?php include "../nav/top_menu.php"; ?>
        </div> <!-- end of menu -->
        
        <div id="content">
            <div id="section_title" >회원가입</div>
            <div id="form_join">
                <form name="member_form" method="post" action="../section/login/join2.php">                
                    <div id="form_join1">
                        <div id="join1">
                            <ul>
                                <li>* 아이디</li>
                                <li>* 비밀번호</li>
                                <li>* 비밀번호 확인</li>
                                <li>* 이름</li>
                                <li>* 닉네임</li>
                                <li>* 휴대폰</li>
                                <li>* 이메일</li>
                                <div id="ad"><li>* 주소</li></div>
                            </ul>
                        </div>
                        <div id="join2">
                            <ul>
                                <li>
                                    <div id="id1"><input type="text" name="userid" id="userid"></div>
                                    <div id="id2"><input type="button" value="중복확인" onclick="chid()"></div>
                                    <input type='hidden' id="userid2" name='userid2' value="">
                                    <div id="id3">4~12자의 영문 소문자, 숫자와 특수기호만 사용할 수 있습니다.</div>
                                </li>
                                <li><input type="password" name="pw" ></li>
                                <li><input type="password" name="pwc" ></li>
                                <li><input type="text" name="username" ></li>
                                <li>
                                    <div id="nick1"><input type="text" name="nickname" id="usernick1"></div>
                                    <div id="nick2"><input type="button" value="중복확인" onclick="chnick()"></div>
                                    <input type='hidden' id="usernick2" name='usernick2' value="">
                                </li>
                                <li>
                                    <input type="text" class="hp" name="hp1" value="010">
                                    - <input type="text" class="hp" name="hp2"> -
                                    <input type="text" class="hp" name="hp3">
                                </li>
                                <li>
                                    <input type="text" id="email1" name="email1"> @
                                    <input type="text" name="email2">
                                </li>
                                <li>
                                    <input type="text" name="post" id="post" onclick="execDaumPostcode()" placeholder="우편번호" >
                                    <input type="button" onclick="execDaumPostcode()" value="우편번호 찾기">
                                    <div id="address_tx1"><input type="text" id="address1" name="address1" onclick="execDaumPostcode()" placeholder="주소" readonly></div>
                                    <div id="address_tx2"><input type="text" id="address2" name="address2" placeholder="상세주소" ></div>
                                </li>                     
                            </ul>
                        </div>
                        <div id="must"> * 모든 항목 기입 바랍니다.^^</div>
                    </div>
                    <input type='hidden' name='sns_type' value="normal">
                    <div id="join_btn">
                        <button type="submit">가입하기</button>
                    </div>
                </form>
            </div>
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
        function chid(){
            
            document.getElementById('userid2').value="";
            var id=document.getElementById('userid').value;
            
            if(id==""){
                alert("아이디를 제대로 입력해주세요.");
                exit;
            }
            ifrm1.location.href="../section/login/check_id.php?userid="+id; 
        }

        function chnick(){

            document.getElementById('usernick2').value="";
            var nick = document.getElementById('usernick1').value;

            if(nick==""){
                alert("닉네임을 제대로 입력해주세요.");
                exit;
            }
            ifrm1.location.href="../section/login/check_nick.php?usernick="+nick;
        }
    </script>
</body>
</html>