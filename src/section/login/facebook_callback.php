<?php
session_start();
# login-callback.php
require '../../login_api/vendor/autoload.php' ;

$fb = new  Facebook \ Facebook ([
  'app_id' => '372859457440225' ,
  'app_secret' => '79dc5f4973ceaf0e73137687dd12374e' ,
  'default_graph_version' => 'v2.10' ,
 ]);

$helper = $fb->getRedirectLoginHelper();
$_SESSION['FBRLH_state']=$_GET['state']; /*Add This*/

try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exception\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exception\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (isset($accessToken)) {
  // Logged in!
  $_SESSION['facebook_access_token'] = (string) $accessToken;

  // Now you can redirect to another page and use the
  // access token from $_SESSION['facebook_access_token']
}

try {
  // Returns a `Facebook\Response` object
  $response = $fb->get('/me?fields=id,name,email', $accessToken);
} catch(Facebook\Exception\ResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exception\SDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$user = $response->getGraphUser();

$id = $user['id'];
$mb_name = $user['name'];
$mb_nickname = $user['name'];
$mb_email = $user['email'];

$email=explode("@", $mb_email);

$sns_type='facebook';

$conn = new mysqli('localhost', 'root', 'LovelY-Su', 'member', '3306');
mysqli_query($conn, "set names utf8");

$sql = "SELECT * FROM member WHERE mem_userid='$id' AND sns_type='$sns_type'";
$result = mysqli_query($conn, $sql);

//$row = $result->num_rows;
$access_token = $accessToken;

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