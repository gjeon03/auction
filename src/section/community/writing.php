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
    //console.log("index : "+index);
    //console.log("sel length : "+sel_files.length);

    sel_files.splice(index, 1);

    var img_id = "#img_id_"+index;
    $(img_id).remove(); 

    //console.log(sel_files);
    
    arr.push(index);
    
    $('#img_del').val(arr);

    //handleImgFileSelect(filesArr);
    //$("#input_imgs").on("change", filesArr);

    //$("#input_imgs").on("change", handleImgFileSelect);
    //$("#input_imgs").trigger('click');
    //handleImgFileSelect(sel_files);
    //var names = $("input[type=file][name='upfile[]']");
    //var i = 0;
    //$(names.get(i)).val();
    /*for(i=0; i<5; i++){
        if(i==index){

        }
    }*/
    //$("#input_imgs").on("change", sel_files);
    //var el;

/*for (var i=0; i<al_no.length; i++){

    el = document.createElement("input");

    el.type = "file";

    el.name = "input_imgs";

    el.value = sel_files[i];

    document.form.appendChild(el);    

}

    document.getElementById("input_imgs").value = sel_files;

*/
}

</script>

<?php
$modified='';
$view_num='';
$menu='';
$category='';

$view_id='';
$title='';
$nickname='';
$item_date = '';
//$item_date = substr($item_date,0,10);
$content='';
$image_name_[0]='';
$image_name_[1]='';
$image_name_[2]='';
$image_name_[3]='';
$image_name_[4]='';
$image_copied_[0]='';
$image_copied_[1]='';
$image_copied_[2]='';
$image_copied_[3]='';
$image_copied_[4]='';

$item[0]='';
$item[1]='';
$item[2]='';
$item[3]='';
$item[4]='';

if(isset($_POST["modified"])&&isset($_SESSION['userid'])) {
    $conn = new mysqli('localhost', 'root', 'LovelY-Su', 'member', '3306');
    mysqli_query($conn, "set names utf8");

    $modified=$_POST["modified"];
    $view_num=$_POST['num'];
    $menu=$_POST['menu'];
    $category=$_POST['category'];
    $dr=$_POST['cm_category'];
    //$view_num=$_POST['view_num'];

    require('_conn.php');

    //$view_num = $_GET['community_view'];

    if(!strcmp($menu, "community:")){
        $table_tt='free';
    }
    if(!strcmp($menu, "notice:")&&!strcmp($_SESSION['userid'], "jeon")){
        $table_tt='notice';
    }
    if(!strcmp($menu, "question:")){
        $table_tt='qeustion';
    }
    $sql_user_info = "SELECT * FROM $table_tt WHERE num='$view_num'";

    $result_user_info = mysqli_query($conn, $sql_user_info);
    foreach($result_user_info as $user){

            $view_id=$user['id'];
            $title=$user['subject'];
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

    }
    
    $file_location = "../ac_loadfile/";
    $menus="community:";

    //echo "<script>document.category.community_find.value=$dr; </script>"; 
    

    $item[$dr] = "selected";

    /*
    <?php
    $image_num =0;
    for($i =0; $i <5; $i++){
            if(strcmp($image_copied_[$i], "")){
                    $image_num ++;
            }
    }
    for ($i=0; $i<$image_num; $i++) {
    ?>
    <div id=images>
            <img class="img3" src="<?=$file_location?><?=$image_copied_[$i]?>">
    </div>
    <?php
    }?> 
    */
}
?>

<div id="section_title" style="font-size:20px">글쓰기</div>
<form id="writing_form"  method="post" action="../section/community/insert.php" enctype="multipart/form-data">
    <table class="writing_list">
        <tr>
            <th scope="row" id="title1">제목</th>
            <td id="writing_text1"><input type="text" name="writing_title" value=<?=$title?>></td>
        </tr>
        <tr>
            <th scope="row" class="title2">이미지 추가</th>
            <td id="writing_text2">
                <div class="input_wrap">
                    <a href="javascript:" onclick="fileUploadAction();" class="my_button">파일 업로드</a>
                    <input type="file" id="input_imgs" name="upfile[]" multiple="multiple">
                    <input type='hidden' id='img_del' name='img_del' value=''>
                </div>
                <div class="imgs_wrap">
                <?php
                if(isset($_POST["modified"])){
                    $image_num =0;
                    for($i =0; $i <5; $i++){
                            if(strcmp($image_copied_[$i], "")){
                                    $image_num ++;
                            }
                    }
                    for ($i=0; $i<$image_num; $i++) {
                            $img_location=$file_location.$image_copied_[$i];
                    ?>
                    
                    <img class="img4" src="<?=$file_location?><?=$image_copied_[$i]?>" max-width='100px' max-height='100px' width='auto' height='auto'>
                    
                    <?php
                    }              
                }else{
                ?>
                    <img id="img4" />
                    <?php
                }
                    ?>
                </div>
            </td>
        </tr>
        <tr>
            <th scope="row" class="title3">내용</th>
            <td><textarea name="writing_contents" rows="20" cols="80"><?=$content?></textarea></td>
        </tr>
        <tr>
            <th scope="row" class="title4">카테고리</th>
            <td id="writing_text4">
                <form  name=category>
                    <select name="community_find">
                            <option type="placeholder">선택해주세요.</option>
                            <option value='benefit' <?=$item[0]?>>개이득</option>
                            <option value='game' <?=$item[1]?>>게임</option>
                            <option value='chat' <?=$item[2]?>>수다</option>
                            <option value='greetings' <?=$item[3]?>>가입인사</option>
                            <option value='etc' <?=$item[4]?>>기타</option>
                    </select>
                </form>
            </td>
        </tr>
    </table>
    <input type='hidden' name='modified' value=<?=$modified?>>
    <input type='hidden' name='num' value=<?=$view_num?>>
    <!--<button id="erm" onclick=test()>등록하기</button> --> 
    <button id="erm" type="submit">등록하기</button>
</form>