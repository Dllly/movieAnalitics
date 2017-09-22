<?php

if(is_uploaded_file($_FILES['userfile']['tmp_name'])){
  if(move_uploaded_file($_FILES['userfile']['tmp_name'],"./".$_FILES['userfile']['name'])){
    echo "uploaded";
  }else{
    echo "error while saving.";
  }
}else{
  echo "file not uploaded.";
}
