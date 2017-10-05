<?php
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

function checkingEos($text){
  $searchWord = 'EOS%0A';
  $urlText = urlEncode($text);
  $noEosText = strstr($urlText, $searchWord, true);
  if ($noEosText){
    $decText = urldecode($noEosText);
    echo $decText;
    return true;
  }
}

$originTexts = file(__DIR__ . '/mophological.txt');
$eos = $originTexts[6];
$eos = "ASEOS";
$ueos = urlEncode($eos);
echo $ueos;
for ($i = 0; $i < count($originTexts); $i++){
  $searchWord = 'EOS%0A';
  $urlText = urlEncode($originTexts[$i]);
  echo $originTexts[$i]. "<br>";
  echo $urlText . "<br>";
  if ($originTexts[$i] === "EOS"){
    echo "yes<br>";
  }
  }
