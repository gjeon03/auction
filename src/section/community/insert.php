<?php 
session_start(); 

if(!isset($_SESSION["userid"])) {

?>
    <script>
    alert('로그인 후 이용해 주세요.');
    history.back();
    </script>
<?php
}

require('/usr/local/apache2.4/htdocs/section/community/_conn.php');
//$conn = new mysqli('localhost', 'root', 'LovelY-Su', 'member', '3306');
//mysqli_query($conn, "set names utf8");

$id = $_SESSION['userid'];
$name = $_SESSION['username']; 
$nick = $_SESSION['nickname'];

$title = $_POST['writing_title'];

$upfile_name[0]=""; //파일명 초기설정
$upfile_name[1]="";
$upfile_name[2]="";
$upfile_name[3]="";
$upfile_name[4]="";
$copied_file_name[0]="";
$copied_file_name[1]="";
$copied_file_name[2]="";
$copied_file_name[3]="";
$copied_file_name[4]="";

/*$imageKind = array('image/pjpeg','image/jpeg','image/JPG','image/jpg','image/X-PNG','image/PNG','image/png','image/x-png');
$dir = '/usr/local/apache2.4/htdocs/ac_loadfile/';

for($i=0; $i<$_POST['image_count']; $i++){
    $image_id = "image_".$i;
    $image_file = time().$i.".jpg";

    if(isset($_FILES[$image_id]) && !$_FILES[$image_id]['error']){
        if(in_array($_FILES[$image_id]['type'], $imageKind)){
            /*if(move_uploaded_file($_FILES[$image_id]['tmp_name'], $dir.$image_file)){
            }else{
            }*/
        /*}else{
            echo "<script>alert('이미지 타입이 맞질 않습니다. (.jpg, .png, .jpeg)'); history.back();</script>";
        }
    }else{
        echo "<script>alert('업로드 에러'); history.back();</script>";
    }
    echo "새롭게 넘어온 이미지 파일 : ".$image_id;
}*/

$files = $_FILES["upfile"]; //첨부파일

if(isset($_POST['img_del'])){
    $img_del1=$_POST['img_del'];

    $img_del=explode(",", $img_del1);

    echo '배열 개수 : '.count($img_del);

    rsort($img_del);

    for($i=0; $i<count($img_del); $i++){
        array_splice($files["name"], $img_del[$i],1);
        array_splice($files["tmp_name"], $img_del[$i],1);
        array_splice($files["type"], $img_del[$i],1);
        array_splice($files["size"], $img_del[$i],1);
        array_splice($files["error"], $img_del[$i],1);

        
    }
    
}

$count = count($files["name"]);

if(strcmp($files["name"][0], "")){//보낸 파일이 없다면 for문을 불러들이지 않는다. 이걸 안하면 무조건 한번은 for문이 돌아서 에러 메시지가 뜸.

    $upload_dir = '/usr/local/apache2.4/htdocs/ac_loadfile/'; //물리적 저장위치
    for ($i=0; $i<$count; $i++){
        $upfile_name[$i] = $files["name"][$i]; 
        $upfile_tmp_name[$i] = $files["tmp_name"][$i];
        $upfile_type[$i] = $files["type"][$i];
        $upfile_size[$i] = $files["size"][$i];
        $upfile_error[$i] = $files["error"][$i];
        $file = explode(".", $upfile_name[$i]);
        $file_name = $file[0];
        $file_ext = $file[1];

        if (!$upfile_error[$i]){
            $new_file_name = date("Y_m_d_H_i_s");
            $new_file_name = $new_file_name."_".$i;
            $copied_file_name[$i] = $new_file_name.".".$file_ext;
            $uploaded_file[$i] = $upload_dir.$copied_file_name[$i];
            if( $upfile_size[$i] > 5000000 ) {
                print("<script>alert('업로드 파일 크기가 지정된 용량(5MB)을 초과합니다!<br>파일 크기를 체크해주세요! ');history.back();</script>");
                exit;
            }
            if (!move_uploaded_file($upfile_tmp_name[$i], $uploaded_file[$i]) ){
                print("<script>alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');</script>");
                //echo "Not uploaded because of error #".$_FILES["file"]["error"];
                exit;
            }
        }
    }

    
}

$content = $_POST['writing_contents'];

$category = $_POST['community_find'];

if (!$title||!$content){
    echo "<script>alert('제목 또는 내용이 입력되었는지 확인해주세요.'); history.back();</script>";
} else if(!$category){
    echo "<script>alert('카테고리를 선택해주세요.'); history.back();</script>";
} else{
    if(!strcmp($_POST['modified'], 'ing')){
        $num=$_POST['num'];

        mysqli_query($conn,"UPDATE free SET subject='$title', content='$content', regist_day=now(), category='$category', file_name_0='$upfile_name[0]', file_name_1='$upfile_name[1]', file_name_2='$upfile_name[2]', file_name_3='$upfile_name[3]', file_name_4='$upfile_name[4]', file_copied_0='$copied_file_name[0]', file_copied_1='$copied_file_name[1]', file_copied_2='$copied_file_name[2]', file_copied_3='$copied_file_name[3]', file_copied_4='$copied_file_name[4]' WHERE num = $num");
        
        echo "<script>window.alert('글 저장 완료되었습니다.')</script>";
        echo "<meta http-equiv='refresh' content='0; url=../../feed/community_form.php'>";

    }else{
        $sql = "INSERT INTO free (id, name, nick, subject, content, regist_day, category, file_name_0, file_name_1, file_name_2, file_name_3, file_name_4, file_copied_0, file_copied_1, file_copied_2, file_copied_3, file_copied_4, hit) VALUES ('$id', '$name', '$nick', '$title', '$content', now(), '$category', '$upfile_name[0]', '$upfile_name[1]', '$upfile_name[2]', '$upfile_name[3]', '$upfile_name[4]', '$copied_file_name[0]', '$copied_file_name[1]', '$copied_file_name[2]', '$copied_file_name[3]', '$copied_file_name[4]', 0)";
        mysqli_query($conn, $sql);

        echo "<script>window.alert('글 저장 완료되었습니다.')</script>";
        echo "<meta http-equiv='refresh' content='0; url=../../feed/community_form.php'>";
    }
}

/*$sql = "SELECT * FROM free";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo "아이디: " . $row["id"]. "이름:"  . $row["name"]. " 내용:" . $row["content"]. "<br>";
    }
}else{
    echo "테이블에 데이터가 없습니다.";
}
mysqli_close($conn);

?>*/