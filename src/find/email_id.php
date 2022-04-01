<?php

require '/usr/share/php/libphp-phpmailer/autoload.php';

$to = $email;
$subject = "중고경매 id";
$message = "아이디 : ".$userid;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// PHPMailer 선언
$mail = new PHPMailer(true);
// 디버그 모드(production 환경에서는 주석 처리한다.)
$mail->SMTPDebug = SMTP::DEBUG_SERVER;
// SMTP 서버 세팅
$mail->isSMTP();
try {
// 구글 smtp 설정
$mail->Host = "";
// SMTP 암호화 여부
$mail->SMTPAuth = true;
// SMTP 포트
$mail->Port = ;
// SMTP 보안 프초트콜
$mail->SMTPSecure = "ssl";
// email 유저 아이디
$mail->Username = ""; //email ID
// email 패스워드
$mail->Password =""; //email PW
// 인코딩 셋
$mail->CharSet = 'utf-8';
$mail->Encoding = "base64";
// 보내는 사람
$mail->setFrom('[email]', 'Auction');
// 받는 사람
$mail->AddAddress($to);
// 본문 html 타입 설정
$mail->isHTML(true);
// 제목
$mail->Subject = $subject;
// 본문 (HTML 전용)
$mail->Body = $message;
// 본문 (non-HTML 전용)
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
$mail->Send();
echo "Message has been sent";
} catch (phpmailerException $e) {
echo $e->errorMessage();
} catch (Exception $e) {
echo $e->getMessage();
}


echo "<script>parent.alert('이메일을 확인해주세요.');window.close();</script>";
//mailer($to,$to2,"naver.com",$subject,$message );
?>