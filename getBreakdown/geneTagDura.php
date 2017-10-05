<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title></title>
</head>
<body>
<input type="button" value="タグ生成する" onClick="location.href='./makingRanking.php'">
<br><br>
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

  $i = 0;
  $result = array();

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
      $resultPush = array_push($result, array("time" => $totalTime));
      echo $resultPush ."test<br>";
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

  foreach ($result as $value){
    foreach($value as $valueSmall){
      echo $valueSmall ."<br>";
    }
  }
  $isShellExec = shell_exec("sh ./mecab.sh");
  echo $isShellExec;
}
?>


</body>
</html>
<?php
function deletingBlank($noun){
  return $word;
}

function pickingNoun($text){
  $searchWord = '名詞';
  $noun = strstr($text, $searchWord, true);
  if ($noun){
    $noun = urlencode($noun);
    $brank = '%09';
    $word = strstr($noun, $brank, true);
    $noun = urldecode($word);
  }
  return $noun;
}

function checkLastLine($text){
  $searchWord = 'EOS%0A';
  $urlText = urlEncode($text);
  $isEos = false;
  if ($urlText === 'EOS%0A'){
    $isEos = true;
  }
  return $isEos;
}

$originTexts = file(__DIR__ . '/mophological.txt');
$result = pickingNoun($originTexts[0]);
$nounsArray = array();
$eosCounter = 0;
$timesCounter = 0;

for ($i = 0; $i < count($originTexts); $i++){
  $pickingResult = pickingNoun($originTexts[$i]);
  $noun ='';

  #checking the end of the sentence
  $isEos = checkLastLine($originTexts[$i]);
  if (!$isEos){
    $eos =  "EOS" . $eosCounter; 
    #echo "eos<br>" . $i;
    echo $eos ."<br>";
    $eosCounter++;
    #echo $eosCounter . "<br>";
  } else {
    $eos = '';
  }

  #checking the continuous nous , and if it exist, putting together. 
  while ($pickingResult){
    $noun = $noun . $pickingResult;
    $pickingResult = pickingNoun($originTexts[++$i]);
    if (!$pickingResult){
      #$addArray =array($noun => '1');
      if (array_key_exists($noun, $nounsArray)){
        $nounsArray[$noun] += 1;
        echo $noun;
      } else {
        #array_push($nounsArray, $noun);
        $nounsArray += array($noun => 1);
        #$nounsArray = array_merge_recursive($nounsArray, $addArray);
        #print_r($nounsArray);
      }
      echo "<br><br>";
      $noun = '';
    }
  }
}
foreach ($nounsArray as $key => $val){
  echo $key . " : " . $val ."<br>";
}
# counting the number of occurences of each value in '$nounsArray'  
#$countValues = array_count_values($nounsArray);

#sorting '$countValues' in ascending numbers.
#$isRankingArray = arsort($countValues, SORT_NUMERIC);
#foreach ($countValues as $key => $val){
#  echo "$key = $val\n" . "<br>";
#}
