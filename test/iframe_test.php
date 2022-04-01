<?php 

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
?>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
<script type="text/javascript">
	var sel_files = [];


    $(document).ready(function() {
        $("#input_imgs").on("change", handleImgFileSelect);
    }); 

    function fileUploadAction() {
        console.log("fileUploadAction");
        $("#input_imgs").trigger('click');
    }

    function handleImgFileSelect(e) {

        arr=[];
        
        // 이미지 정보들을 초기화
        sel_files = [];
        $(".imgs_wrap").empty();

        var files = e.target.files;
        var filesArr = Array.prototype.slice.call(files);

        
        //var index2=0;

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
var arr = new Array();
function deleteImageAction(index) {
    console.log("index : "+index);
    console.log("sel length : "+sel_files.length);

    sel_files.splice(index, 1);

    var img_id = "#img_id_"+index;
    $(img_id).remove();
    
    //arr[index2]=index+",";
    //index2++;
    arr.push(index);
    
    $('#imgg').val(arr);
    //var imgg=document.getElementById("imgg").value
    //imgg.value=arr;
}

</script>

<div id="section_title" style="font-size:20px">상품 등록</div>
<form id="writing_form" action="ajax_test.php" method="post" enctype="multipart/form-data">
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
                    <input type='hidden' id='imgg' name='imgg' value='asd'>
                </div>
                <div class="imgs_wrap">
                    <img id="img" />
                </div>
            </td>
        </tr>
        <tr>
            <th scope="row" class="title3">경매 기간</th>
            <td id="writing_text3">
                <?php
                if(!strcmp($check_id, $user_id)){
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
    <button id="erm" type="submit"><?=$savr_btn?></button> 
</form>