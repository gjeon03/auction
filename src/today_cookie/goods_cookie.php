<?php

$cookiePno = $view_num; // 상품번호

if(isset($_COOKIE['goods_today_view'])){ // today_view라는 쿠키가 존재하면
	$todayview=$_COOKIE['goods_today_view']; // $todayview 변수에 today_view 쿠키를 저장한다.
	
	$tod2=explode(",", $_COOKIE['goods_today_view']); // today_view 쿠키를 ','로 나누어 구분한다.
	//$tod=array_reverse($tod2); // 최근 목록을 뽑기 위해 배열을 최신 값이 0에 오게 한다.(배열을 뒤집음)
	
	if( array_search($cookiePno, $tod2) === false){
		$az = "yes";
		
	}else {
		$az ="";
	}
	//쿠키에 값 추가
	if($az == "yes"){
		setcookie('goods_today_view', $todayview.",".$cookiePno, time() + 86400, "/");
	}
}else { // 저장된 쿠키값이 없을 경우 새로 쿠키를 저장하는 소스
	//echo "<script>window.alert('쿠키 호출2222이 완료되었습니다.')</script>";
	setcookie('goods_today_view', $cookiePno, time() + 3600*24, "/");
}
?>