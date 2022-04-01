<?php
session_start();

if(!isset($_POST['del'])){
    echo "<script>alert('잘못된 경로로 접속하셨습니다.'); history.back();</script>";
}else{
    $conn = new mysqli('localhost', 'root', 'LovelY-Su', 'member', '3306');
    mysqli_query($conn, "set names utf8");

    $id=$_SESSION['userid'];
    $sns_type='';
    $sql_user_info = "SELECT * FROM member WHERE mem_userid='$id'";
    $result_user_info = mysqli_query($conn, $sql_user_info);
    foreach($result_user_info as $user){
        $sns_type=$user['sns_type'];
        $access_token=$user['access_token'];
    }
    //echo $sns_type;
    /*if(!strcmp($sns_type, 'normal')){
        $sql = "DELETE FROM member WHERE mem_userid='$id'";
        $result= mysqli_query($conn, $sql);
        
        echo "<script>alert('탈퇴 하였습니다.');</script>";

        require '../section/login/logout.php';

        //echo "<meta http-equiv='refresh' content='0; url=https://192.168.136.130/index.php>";
        
    }else*/
    if(!strcmp($sns_type, 'naver')){
        define('NAVER_CLIENT_ID', 'ObhfZDRsKVUmWtQk8Z7R'); 
        define('NAVER_CLIENT_SECRET', 'Y2tI7gDjwV'); // 네이버 접근 토큰 삭제 
        $naver_curl = "https://nid.naver.com/oauth2.0/token?grant_type=delete&client_id=".NAVER_CLIENT_ID."&client_secret=".NAVER_CLIENT_SECRET."&access_token=".urlencode($access_token)."&service_provider=NAVER"; 
        $is_post = false; 
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $naver_curl); 
        curl_setopt($ch, CURLOPT_POST, $is_post); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        $response = curl_exec ($ch); 
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
        curl_close ($ch); 
        if($status_code == 200) { 
            $responseArr = json_decode($response, true); // 멤버 DB에서 회원을 탈퇴해주고 로그아웃(세션, 쿠키 삭제) 
            if ($responseArr['result'] != 'success') { 
                // 오류가 발생하였습니다. 네이버 내정보->보안설정->외부 사이트 연결에서 해당앱을 삭제하여 주십시오 
            } 
        } else { 
            // 오류가 발생하였습니다. 네이버 내정보->보안설정->외부 사이트 연결에서 해당앱을 삭제하여 주십시오. 
        }

    }elseif(!strcmp($sns_type, 'kakao')){
        $UNLINK_API_URL = "https://kapi.kakao.com/v1/user/unlink"; 
        $opts = array( 
            CURLOPT_URL => $UNLINK_API_URL, 
            CURLOPT_SSL_VERIFYPEER => false, 
            CURLOPT_SSLVERSION => 1, 
            CURLOPT_POST => true, 
            CURLOPT_POSTFIELDS => false, 
            CURLOPT_RETURNTRANSFER => true, 
            CURLOPT_HTTPHEADER => array( "Authorization: Bearer " . $access_token ) ); 
            $curlSession = curl_init(); 
            curl_setopt_array($curlSession, $opts); 
            $accessUnlinkJson = curl_exec($curlSession); 
            curl_close($curlSession); 
            $unlink_responseArr = json_decode($accessUnlinkJson, true);
    }elseif(!strcmp($sns_type, 'facebook')){
        $face_id ='372859457440225';
        $url = "https://graph.facebook.com/$id/permissions?access_token=$access_token";

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "DELETE"
        ));
        curl_exec($curl);
        //return curl_exec($curl);
    }

    $sql = "DELETE FROM member WHERE mem_userid='$id'";
    $result= mysqli_query($conn, $sql);
    
    echo "<script>alert('탈퇴 하였습니다.');</script>";

    echo "<meta http-equiv='refresh' content='0;url=../section/login/logout.php'>";
    //require '../section/login/logout.php';
}

?>