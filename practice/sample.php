<?php

    //一字ファイルができているか（アップロードされているか）チェック
    if(is_uploaded_file($_FILES['up_file']['tmp_name'])){

        //一字ファイルを保存ファイルにコピーできたか
        if(move_uploaded_file($_FILES['up_file']['tmp_name'],"./".$_FILES['up_file']['name'])){

            //正常
            echo "uploaded";

        }else{

            //コピーに失敗（だいたい、ディレクトリがないか、パーミッションエラー）
            echo "error while saving.";
        }

    }else{

        //そもそもファイルが来ていない。
        echo "file not uploaded.";

    }
