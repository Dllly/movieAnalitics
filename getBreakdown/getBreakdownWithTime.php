<?php
function convertTime($strTime){
  $pattern = '/\d{2}/';
  preg_match_all($pattern, $strTime, $match);
  #print_r($match);
  $hour = ((int)$match[0][0]) * 60 * 60;
  $minute = ((int)$match[0][1]) * 60;
  $second = ((int)$match[0][2]);
  $totalTime = $hour + $minute + $second;
  return $totalTime;
}

$videoId = $_POST['videoId'];
$ch = curl_init();
$headers = array(
  "Ocp-Apim-Subscription-Key:1fb39f00ae48491f81a35300aeaa690a",
  );
$fp = fopen('/var/www/html/dev/movieAnalitics/upload/curl.log', 'a');
$curlUrl = 'https://videobreakdown.azure-api.net/Breakdowns/Api/Partner/Breakdowns/' . $videoId;
#$cfile = new CURLFile('/var/www/html/dev/movieAnalitics/upload/upload.mp4', 'video/mp4', 'uptest.mp4');

curl_setopt_array($ch, [ 
  CURLOPT_HTTPHEADER => $headers,
  CURLOPT_URL => $curlUrl,
  CURLOPT_STDERR => $fp,
  CURLOPT_RETURNTRANSFER => true,
]);
$response = curl_exec($ch);
$isFileMaking = file_put_contents("./json/breakdown.json", $response);
if (!$isFileMaking) {
  echo "Fail to make Json fiel.";
}

$jsonUrl = "json/breakdown.json";
if (file_exists($jsonUrl)){
  $json = file_get_contents($jsonUrl);
  $json = mb_convert_encoding($json, 'UTF-8','ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
  $obj = json_decode($json, true);
  $obj = $obj["breakdowns"][0]["insights"]["transcriptBlocks"];
  
  $a = fopen("input.txt" , "w");
  @fwrite($a, "");
  fclose($a);

  foreach($obj as $key=> $val){
    $ocrsIndex = $val["ocrs"];
     foreach ($ocrsIndex as $keyOcr => $valOcr) {
      echo $valOcr["timeRange"]["start"] . "<br>";
      echo $valOcr["timeRange"]["end"] . "<br>";
      $startTime = $valOcr["timeRange"]["start"];
      $startTime = convertTime($startTime);
      
      $endTime = $valOcr["timeRange"]["end"];
      $endTime = convertTime($endTime);

      $totalTime = $endTime - $startTime;
      echo $totalTime ."<br>";

      $objId = $valOcr["lines"];
      foreach($objId as $keyId=>$valID){
        echo "ID:",$valID["id"],":";
        echo $valID["textData"], "<br>";
        $flags = 2;
        file_put_contents("input.txt", $valID["textData"] . PHP_EOL, FILE_APPEND);
      }
      echo "<br>";
    }
  }

  $isShellExec = shell_exec("sh ./mecab.sh");
  echo $isShellExec;
}
