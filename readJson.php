<?php

$jsonUrl = "json/breakdown.json";
if (file_exists($jsonUrl)){
  $json = file_get_contents($jsonUrl);
  $json = mb_convert_encoding($json, 'UTF-8','ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
  $obj = json_decode($json, true);
  $obj = $obj["breakdowns"][0]["insights"]["transcriptBlocks"];

  foreach($obj as $key=> $val){
    $ocrsIndex = $val["ocrs"];
     foreach ($ocrsIndex as $keyOcr => $valOcr) {
        echo $valOcr["timeRange"]["start"], "<br>";
        echo $valOcr["timeRange"]["end"],"<br>";
      
        $objId = $valOcr["lines"];
        foreach($objId as $keyId=>$valID){
          echo "ID:",$valID["id"],":";
          echo $valID["textData"], "<br>";
        }
        echo "<br><br>";
     }
  }
}
