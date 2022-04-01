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

}
</script>

<div id="section_title" style="font-size:20px">문의하기</div>
<form id="writing_form" action="../section/service_center/questions_insert.php" method="post" enctype="multipart/form-data">
    <table class="writing_list">
        <tr>
            <th scope="row" class="title1">제목</th>
            <td id="writing_text1"><input type="text" name="writing_title"></td>
        </tr>
        <tr>
            <th scope="row" class="title2">이미지 추가</th>
            <td id="writing_text2">
                <div class="input_wrap">
                    <a href="javascript:" onclick="fileUploadAction();" class="my_button">파일 업로드</a>
                    <input type="file" id="input_imgs" name="upfile[]" multiple="multiple">
                </div>
                <div class="imgs_wrap">
                    <img id="img" />
                </div>
            </td>
        </tr>
        <tr>
            <th scope="row" class="title3">내용</th>
            <td><textarea name="writing_contents" rows="20" cols="90%"></textarea></td>
        </tr>        
    </table>
    <button id="erm" type="submit">문의하기</button> 
</form>