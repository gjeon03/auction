<!DOCTYPE html>
<html>
<body>
  <?php
  $location=$_GET['location'];
  $name=$_GET['name'];
  ?>
  <img id="img2" name="img22" src=<?=$location?><?=$name?>>
    <style>
        #img2{
            padding:5px;
            width:380px;
            height: 530px;
        }
    </style>
</body>
</html>