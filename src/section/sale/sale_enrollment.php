<?php 

if(!isset($_SESSION["userid"])) {

?>
    <script>
    alert('로그인 후 이용해 주세요.');
    history.back();
    </script>
<?php
}
$category_cho[0]='';
$category_cho[1]='';
$category_cho[2]='';
$category_cho[3]='';
$category_cho[4]='';
$category_cho[5]='';
$category_cho[6]='';

$rating_cho[0]='';
$rating_cho[1]='';
$rating_cho[2]='';
$rating_cho[3]='';
$rating_cho[4]='';

$term_cho[0]='';
$term_cho[1]='';
$term_cho[2]='';
$term_cho[3]='';

$total_term[0]='';
$total_term[1]='';

$item_model='';

$item_brand='';

$readonly='';

$savr_btn='등록하기';

$mo='';

$item_num='';
$item_subject='';
$item_price='';
$content='';

if(isset($_GET['goods_num'])){

    $readonly='readonly';
    $savr_btn='수정하기';

    $mo='ing';

    $item_num=$_GET['goods_num'];
    $check_id=$_SESSION['userid'];

    $conn = new mysqli('localhost', 'root', 'LovelY-Su', 'member', '3306');
    mysqli_query($conn, "set names utf8");

    $sql_user_info = "SELECT * FROM goods WHERE num='$item_num'";

    $result_user_info = mysqli_query($conn, $sql_user_info);
    foreach($result_user_info as $user){

        $view_id=$user['id'];
        $title=$user['subject'];
        $item_subject=str_replace(" ", "&nbsp;", $user["subject"]);
        $nickname=$user['nick'];
        $item_date = $user["regist_day"];
        //$item_date = substr($item_date,0,10);
        $content=$user['content'];
        $image_name_[0]=$user['file_name_0'];
        $image_name_[1]=$user['file_name_1'];
        $image_name_[2]=$user['file_name_2'];
        $image_name_[3]=$user['file_name_3'];
        $image_name_[4]=$user['file_name_4'];
        $image_copied_[0]=$user['file_copied_0'];
        $image_copied_[1]=$user['file_copied_1'];
        $image_copied_[2]=$user['file_copied_2'];
        $image_copied_[3]=$user['file_copied_3'];
        $image_copied_[4]=$user['file_copied_4'];

        $item_num=$user["num"];
        $item_time=$user["goods_time"];
        $item_price=$user["goods_price"];
        $item_complete=$user["complete"];
        $item_model=$user['model'];
        $item_brand=$user['brand'];
        $item_term=$user['term'];
        $item_rating=$user['goods_rating'];
        $name=$user['name'];

        $type=$user['sns_type'];
        $bidder_id=$user['bidder_id'];
        $user_id=$user['id'];
        $phone1=$user['phone'];

        $my_type=$user['my_sns_type'];

        $category=$user['category'];
    }

    if(!strcmp($check_id, $user_id)){
        $total_category= array("fashion", "beauty", "life", "digital", "interior", "books", "etc");
        for($i=0; $i<count($total_category); $i++){
            if(!strcmp($category, $total_category[$i])){
                $dr=$i;
            }
        }

        $total_rating= array("A", "B", "C", "D", "E");
        for($i=0; $i<count($total_rating); $i++){
            if(!strcmp($item_rating, $total_rating[$i])){
                $dr1=$i;
            }
        }

        $total_term=explode(" ", $item_term);

        $total_term2= array("시간", "일", "달", "년");
        for($i=0; $i<count($total_term2); $i++){
            if(!strcmp($total_term[1], $total_term2[$i])){
                $dr2=$i;
            }
        }

        $category_cho[$dr] = "selected";
        $rating_cho[$dr1] = "selected";
        $term_cho[$dr2] = "selected";
    }else{
        echo "<script>alert('잘못된 접근입니다.'); history.back();</script>";
    }
}

$file_location = "../ac_loadfile2/";
?>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
<script type="text/javascript">
	var sel_files = [];
    var arr = [];

    $(document).ready(function() {
        $("#input_imgs").on("change", handleImgFileSelect);
    }); 

    function fileUploadAction() {
        console.log("fileUploadAction");
        $("#input_imgs").trigger('click');
    }

    function handleImgFileSelect(e) {
        arr = [];
        // 이미지 정보들을 초기화
        sel_files = [];
        $(".imgs_wrap").empty();

        var files = e.target.files;
        var filesArr = Array.prototype.slice.call(files);

        var index = 0;
        if(Array.prototype.slice.call(files).length>5){
            alert("최대 5개 까지 가능합니다.");
            return;
        }

        filesArr.forEach(function(f) { 
            if(!f.type.match("image.*")) {
                alert("확장자는 이미지 확장자만 가능합니다.");
                return;
        }
            
        sel_files.push(f);

        var reader = new FileReader();
        reader.onload = function(e) {
            var html = "<a href=\"javascript:void(0);\" onclick=\"deleteImageAction("+index+")\" id=\"img_id_"+index+"\"><img src=\"" + e.target.result + "\" data-file='"+f.name+"' class='selProductFile' title='Click to remove'></a>";
            $(".imgs_wrap").append(html);
            index++;

        }
        reader.readAsDataURL(f);
            
    });
}

function deleteImageAction(index) {
    console.log("index : "+index);
    console.log("sel length : "+sel_files.length);

    sel_files.splice(index, 1);

    var img_id = "#img_id_"+index;
    $(img_id).remove(); 

    arr.push(index);
    
    $('#img_del').val(arr);
}

//function submitAction(){
function test()  {
    alert("12312313 가능합니다.");
    // 입력란에 name='age' 값을 저장합니다 
    //var age = $(this).find('[name=age]').val();
    var formData = $("#writing_form").serialize();
    alert("12312313 가능합니다.");
    var formDatas = new FormData();
    /*$each($('#upfiles')[0].files, function(i, file) {
        formDatas.append('upfiles-'+i, file);
    });*/
    alert("12312313 가능합니다.");
    /*$each($('#upfiles')[0].files, function(i, file) {
        data.append('upfiles[]', file);
    });*/
    alert("12312313 가능합니다.");
    //var image_file = $('#upfiles')[0];
    //var formDatas = new FormData(image_file);

	var data_file = new FormData();

	for(var i=0, len=sel_files.length; i<len; i++) {
		var name ="image_"+i;
		data_file.append(name, sel_files[i]);
	}
	data_file.append("image_count", sel_files.length);
    alert("12312313 가능합니다.");
    $.ajax({
        url: '../section/community/insert.php',
        type: 'POST',
        method: 'POST',
        data: formData, data_file, formDatas,
        contentType : false,
        processData : false
    }).then((data, textStatus, jqXHR) => {
        alert("2 가능합니다.");
        alert(console.log(data));
    }, (jqXHR, textStatus, errorThrown) => {
        alert("3 가능합니다.");
        /*pass*/
    });

	/*var xhr = new XMLHttpRequest();
	xhr.open("POST", "./study01_af.php");
	xhr.onload = function(e){
		if(this.status == 200){
			console.log("Result : "+e.currenTarget.responseText);
		}
	}

	xhr.send(data);*/
//}action="../section/community/insert.php"
}
</script>

<div id="section_title" style="font-size:20px">상품 등록</div>
<form id="writing_form" action="../section/sale/goods_insert.php" method="post" enctype="multipart/form-data">
    <table class="writing_list">
        <tr>
            <th scope="row" class="title1">제목</th>
            <td id="writing_text1"><input type="text" name="writing_title" value=<?=$item_subject?>></td>
        </tr>
        <tr>
            <th scope="row" class="title2">이미지 추가</th>
            <td id="writing_text2">
                <div class="input_wrap">
                    <a href="javascript:" onclick="fileUploadAction();" class="my_button">파일 업로드</a>
                    <input type="file" id="input_imgs" name="goods_file[]" multiple="multiple">
                    <input type='hidden' id='img_del' name='img_del' value=''>
                </div>
                <div class="imgs_wrap">
                <?php
                if(isset($_GET["modified"])){
                    $image_num =0;
                    for($i =0; $i <5; $i++){
                            if(strcmp($image_copied_[$i], "")){
                                    $image_num ++;
                            }
                    }
                    for ($i=0; $i<$image_num; $i++) {
                            $img_location=$file_location.$image_copied_[$i];
                    ?>
                    
                    <img class="img" src="<?=$file_location?><?=$image_copied_[$i]?>" max-width='100px' max-height='100px' width='auto' height='auto'>
                    
                    <?php
                    }              
                }else{
                ?>
                    <img id="img" />
                    <?php
                }
                    ?>
                </div>
            </td>
        </tr>
        <tr>
            <th scope="row" class="title3">경매 기간</th>
            <td id="writing_text3">
                <?php
                if(isset($_GET["modified"])){
                    echo '수정불가';
                }else{
                ?>
                <select name="auction_date">
                        <option type="placeholder">선택</option>
                        <option value='1'>1</option>
                        <option value='2'>2</option>
                        <option value='3'>3</option>
                        <option value='4'>4</option>
                        <option value='5'>5</option>
                </select> 일
                <?php
                }
                ?>
            </td>
        </tr>
        <tr>
            <th scope="row" class="title4">경매 시작가</th>
            <td id="writing_text4"><input type="text" name="auction_money" value=<?=$item_price?> <?=$readonly?>> 원</td>
        </tr>
        <tr>
            <th scope="row" class="title5">브랜드</th>
            <td id="writing_text5"><input type="text" name="brand" value=<?=$item_brand?>></td>
        </tr>
        <tr>
            <th scope="row" class="title6">모델명</th>
            <td id="writing_text6"><input type="text" name="model" value=<?=$item_model?>></td>
        </tr>
        <tr>
            <th scope="row" class="title7">사용기간</th>
            <td id="writing_text7"><input type="text" name="term1" value=<?=$total_term[0]?>> 
                <select name="term2">
                        <option type="placeholder">선택</option>
                        <option value='시간' <?=$term_cho[0]?>>시간</option>
                        <option value='일' <?=$term_cho[1]?>>일</option>
                        <option value='달' <?=$term_cho[2]?>>달</option>
                        <option value='년' <?=$term_cho[3]?>>년</option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row" class="title8">품질</th>
            <td id="writing_text8">
                <select name="rating">
                        <option type="placeholder">선택</option>
                        <option value='A' <?=$rating_cho[0]?>>A</option>
                        <option value='B' <?=$rating_cho[1]?>>B</option>
                        <option value='C' <?=$rating_cho[2]?>>C</option>
                        <option value='D' <?=$rating_cho[3]?>>D</option>
                        <option value='E' <?=$rating_cho[4]?>>E</option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row" class="title9">추가 설명</th>
            <td id="writing_text9"><textarea name="writing_contents" rows="20" cols="110" style="resize:none" ><?=$content?></textarea></td>
        </tr>
        <tr>
            <th scope="row" class="title10">카테고리</th>
            <td id="writing_text10">
                <select name="writing_find">
                        <option type="placeholder">선택</option>
                        <option value='fashion' <?=$category_cho[0]?>>패션 의류/잡화</option>
                        <option value='beauty' <?=$category_cho[1]?>>뷰티</option>
                        <option value='life' <?=$category_cho[2]?>>생할 용품</option>
                        <option value='digital' <?=$category_cho[3]?>>가전 디지털</option>
                        <option value='interior' <?=$category_cho[4]?>>홈 인테리어</option>
                        <option value='books' <?=$category_cho[5]?>>도서/음반/DVD</option>
                        <option value='etc' <?=$category_cho[6]?>>기타</option>
                </select>
            </td>
        </tr>
    </table>
    <input type='hidden' name='num' value=<?=$item_num?>>
    <input type='hidden' name='goods_modified' value=<?=$mo?>>
    <input type='hidden' name='complete' value="ing">
    <input type='hidden' name='auction_date' value='0'>
    <button id="erm" type="submit"><?=$savr_btn?></button> 
</form>