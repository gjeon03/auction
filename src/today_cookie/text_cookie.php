<?php

$cookiePno = $menu.$view_num; // 상품번호

if(isset($_COOKIE['text_today_view'])){ // today_view라는 쿠키가 존재하면
	$todayview=$_COOKIE['text_today_view']; // $todayview 변수에 today_view 쿠키를 저장한다.
	
	$tod2=explode(",", $_COOKIE['text_today_view']); // today_view 쿠키를 ','로 나누어 구분한다.
	//$tod=array_reverse($tod2); // 최근 목록을 뽑기 위해 배열을 최신 값이 0에 오게 한다.(배열을 뒤집음)
	
	if( array_search($cookiePno, $tod2) === false){
		$az = "yes";
		
		/*if($az != "yes"){
			setcookie("goods_view", $_COOKIE['goods_view'].",".$_GET['Code'].",".$_GET['CatNo'],time() + 86400,"/");
		}*/
	}else {
		$az ="";
	}
	//쿠키에 값 추가
	if($az == "yes"){
		setcookie('text_today_view', $todayview.",".$cookiePno, time() + 86400, "/");
	}
	//변수에 배열로 넣어준값의 중복을 array_unique()로 없애준다.
	//중복제거
	//$tod=array_unique($tod);
	
	//쿠키 초기화
	//setcookie("user_id_cookie", time()-3600,"/");
	
	//중복을 제거한 배열을 다시 돌려준다.
	//$tod=array_reverse($tod);
	
	//배열을 합쳐준다.
	/*for($i=0; $i<count($tod); $i++){
		if($i==0){
			setcookie('text_today_view', $tod[$i], time() + 3600*24, "/");
		}else{
			$todayview=$_COOKIE['text_today_view'];
		}
		setcookie('text_today_view', $todayview.",".$tod[$i], time() + 3600*24, "/");
	}*/

}else { // 저장된 쿠키값이 없을 경우 새로 쿠키를 저장하는 소스
	//echo "<script>window.alert('쿠키 호출2222이 완료되었습니다.')</script>";
	setcookie('text_today_view', $cookiePno, time() + 3600*24, "/");
}
?>