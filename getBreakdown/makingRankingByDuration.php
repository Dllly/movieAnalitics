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
  } else {
    $noun = false;
  }
  return $noun;
}

function checkLastLine($text){
  $searchWord = 'EOS%0A';
  $urlSentence = urlencode($text);
  $result = strstr($urlSentence, $searchWord, true);
  if ($result === 'EOS%0A'){
    $isEos = true;
  } else {
    $isEos = false;
  }
  return $isEos;
}

$originTexts = file(__DIR__ . '/mophological.txt');
$eosTimeJson = file_get_contents(__DIR__. '/eosTime.json');
$eosTimeArray = json_decode($eosTimeJson, true);


$nounsArray = array();
$noun ='';
#$eosArrayKey is used in $eosTimeArray as its key.
$eosArrayKey = 'EOS0';
#eosTime is the duration of appearence of a sentence in the video.
$eosTime = $eosTimeArray[$eosArrayKey];
$isEos = true;
$eosCounter = 0;

for ($i = 0; $i < count($originTexts); $i++){
  #checking the end of the sentence
  $pickingResult = pickingNoun($originTexts[$i]);
    #checking the continuous nous , and if it exist, putting together. 
    while ($pickingResult){
      $noun = $noun . $pickingResult;
      $pickingResult = pickingNoun($originTexts[++$i]);
    }

    $word = 'EOS%0A';
    $url = urlencode($originTexts[$i]);
    $result =strstr($url, $word);
    if ($result == "EOS%0A"){
      $eosCounter++;
      $eosArrayKey = 'EOS' . $eosCounter;
      $eosTime = $eosTimeArray[$eosArrayKey];
    } else {
    }
    if(array_key_exists($noun, $nounsArray)){
      $nounsArray[$noun] += $eosTime;
    } else {
      $nounsArray += array($noun => $eosTime);
    }
    $noun = '';
}
$isSort = arsort($nounsArray);
foreach ($nounsArray as $key => $val){
  echo $key . " : " . $val ."<br>";
}
