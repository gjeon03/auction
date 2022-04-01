
<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <title>jQuery Event</title>
  <body>
  <?php
$files = $_FILES["image_count"]; //첨부파일

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
            /*if (!move_uploaded_file($upfile_tmp_name[$i], $uploaded_file[$i]) ){
                print("<script>alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');history.back();</script>");
                //echo "Not uploaded because of error #".$_FILES["file"]["error"];
                exit;
            }*/
        }
    }

    
}

if ( 0 < $_FILES['file']['error'] ) {
    echo 'Error: ' . $_FILES['file']['error'] . '<br>';
}
else {
    //move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $_FILES['file']['name']);
    echo '파일파일:'.$_FILES['file']['tmp_name'], 'uploads/' . $_FILES['file']['name'];
}


$files = $_FILES["goods_file"]; //첨부파일

$count = count($files["name"]);

if(strcmp($files["name"][0], "")){//보낸 파일이 없다면 for문을 불러들이지 않는다. 이걸 안하면 무조건 한번은 for문이 돌아서 에러 메시지가 뜸.

    $upload_dir = '/usr/local/apache2.4/htdocs/ac_loadfile2/'; //물리적 저장위치
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
                print("<script>alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');history.back();</script>");
                //echo "Not uploaded because of error #".$_FILES["file"]["error"];
                exit;
            }
        }
    }

    
}

$hi=$_POST['imgg'];
?>

<div>히든값 <?=$hi?></div>
<div>파일 값</div>
<div>name: <?=$upfile_name[0]?></div>
<div>tmp name: <?=$upfile_tmp_name[0]?></div>
<div>type: <?=$upfile_type[0]?></div>
<div>size: <?=$upfile_size[0]?></div>
<div>error: <?=$upfile_error[0]?></div>
<div>name2: <?=$file_name?></div>
<div>ext: <?=$file_ext?></div>

<span id="msg" style="color:red"></span><br/>
    <input type="file" id="photo"><br/>
  <script type="text/javascript" src="jquery-3.2.1.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      $(document).on('change','#photo',function(){
        var property = document.getElementById('photo').files[0];
        var image_name = property.name;
        var image_extension = image_name.split('.').pop().toLowerCase();

        if(jQuery.inArray(image_extension,['gif','jpg','jpeg','']) == -1){
          alert("Invalid image file");
        }

        var form_data = new FormData();
        form_data.append("file",property);
        $.ajax({
          url:'upload.php',
          method:'POST',
          data:form_data,
          contentType:false,
          cache:false,
          processData:false,
          beforeSend:function(){
            $('#msg').html('Loading......');
          },
          success:function(data){
            console.log(data);
            $('#msg').html(data);
          }
        });
      });
    });
  </script>
</body>
</html>
