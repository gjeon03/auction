<?php
session_start();

if (!isset($_GET['state'])) { 
    echo "<script>alert('오류가 발생하였습니다. 잘못된 경로로 접근 하신것 같습니다. '); history.back();</script>";
}

// 네이버 로그인 콜백 예제
$restAPIKey = "70265c74fc52a7a20a2ead4c7de06482";
//$client_secret = "Y2tI7gDjwV";
$code = $_GET["code"];
$state = $_GET["state"];
$callbacURI = urlencode("https://192.168.136.130/section/login/kakao_callback.php"); //본인의 Call Back URL을 입력해주세요

//$redirectURI = urlencode("https://192.168.136.130/section/login/kakao_callback.php");
$url = "https://kauth.kakao.com/oauth/token?grant_type=authorization_code&client_id=".$restAPIKey."&redirect_uri=".$callbacURI."&code=".$code;

$is_post = false;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, $is_post);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$headers = array();
$response = curl_exec ($ch);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//echo "status_code:".$status_code."";
curl_close ($ch);



$me_ch = curl_init();
    //echo "아아ㅏㅏ : ".$response.'<br>';

$responseArr = json_decode($response, true); 
$_SESSION['kakao_access_token'] = $responseArr['access_token']; 
$_SESSION['kakao_refresh_token'] = $responseArr['refresh_token']; // 토큰값으로 네이버 회원정보 가져오기 
$_SESSION['kakao_refresh_token_expires_in'] = $responseArr['refresh_token_expires_in'];

$me_headers = array( 'Content-Type: application/json', sprintf('Authorization: Bearer %s', $responseArr['access_token']) ); 
$me_is_post = false; 
$me_ch = curl_init(); curl_setopt($me_ch, CURLOPT_URL, "https://kapi.kakao.com/v2/user/me"); 
curl_setopt($me_ch, CURLOPT_POST, $me_is_post); 
curl_setopt($me_ch, CURLOPT_HTTPHEADER, $me_headers); 
curl_setopt($me_ch, CURLOPT_RETURNTRANSFER, true); 
$me_response = curl_exec ($me_ch); 
$me_status_code = curl_getinfo($me_ch, CURLINFO_HTTP_CODE); 
curl_close ($me_ch);

$me_responseArr = json_decode($me_response, true);

$id = $me_responseArr['id']; // 아이디
$mb_name = $me_responseArr['properties']['nickname']; // 이름
$mb_nickname = $me_responseArr['properties']['nickname']; // 닉네임 
$mb_email = $me_responseArr['kakao_account']['email']; // 이메일 
//$profileResponse->kakao_account->email;
$email=explode("@", $mb_email);

$sns_type='kakao';

$conn = new mysqli('localhost', 'root', 'LovelY-Su', 'member', '3306');
mysqli_query($conn, "set names utf8");

$sql = "SELECT * FROM member WHERE mem_userid='$id' AND sns_type='$sns_type'";
$result = mysqli_query($conn, $sql);

//$row = $result->num_rows;
$access_token = $responseArr['access_token'];

//echo $access_token;

if(mysqli_num_rows($result) > 0){
    $sql = "UPDATE member SET access_token = '$access_token' WHERE mem_userid = '$id'";
    mysqli_query($conn, $sql);

    require 'loginok.php';

    echo "<script>window.alert('로그인이 완료되었습니다.')</script>";
    echo "<meta http-equiv='refresh' content='0;url=../../index.php'>";
}else{
    ?>
    <link rel="stylesheet" type="text/css" href="../../css/sns_api.css">
    <div id='title'>휴대폰 번호와 주소를 입력해주세요.</div>
    <form name="member_form" method="post" action="join2.php">                
        <div id="form_join1">
            <div id="join1">
                <table class="detail1">
                    <tr>
                        <th scope="row">휴대폰</th>
                        <td>
                          <input type="text" class="hp" name="hp1" value="010">
                          - <input type="text" class="hp" name="hp2"> -
                          <input type="text" class="hp" name="hp3">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">주소</th>
                        <td id='ad_input'>
                          <input type="text" name="post" id="post" onclick="execDaumPostcode()" placeholder="우편번호" >
                          <input type="button" onclick="execDaumPostcode()" value="우편번호 찾기">
                          <div id="address_tx1"><input type="text" id="address1" name="address1" onclick="execDaumPostcode()" placeholder="주소" readonly></div>
                          <div id="address_tx2"><input type="text" id="address2" name="address2" placeholder="상세주소" ></div>
                        </td>
                    </tr>                     
                </table>
            </div>
        </div>
        <input type='hidden' name='userid' value="<?=$id?>">
        <input type='hidden' name='username' value="<?=$mb_name?>">
        <input type='hidden' name='nickname' value="<?=$mb_nickname?>">
        <input type='hidden' name='email1' value="<?=$email[0]?>">
        <input type='hidden' name='email2' value="<?=$email[1]?>">
        <input type='hidden' name='sns_type' value='<?=$sns_type?>'>
        <input type='hidden' name='access_token' value="<?=$access_token?>">
        <div id="join_btn">
            <button type="submit">저장하기</button>
        </div>
    </form>
    <?php
}

?>
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