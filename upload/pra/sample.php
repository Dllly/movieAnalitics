<?php

if(is_uploaded_file($_FILES['userfile']['tmp_name'])){
  if(move_uploaded_file($_FILES['userfile']['tmp_name'],"./".$_FILES['userfile']['name'])){
    $fileName = $_FILES['userfile']['name'];
    #$isChangingFileName = rename($fileName, "input.mp4");
    if ($isChangingFileName) {
      
      echo "uploaded";
    }else{
       echo "error name changing";
    }
  } else {
      echo "error file moving.";  
  }
}else{
  echo "file not uploaded.";
}
