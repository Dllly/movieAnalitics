<?php
function pickingNoun($text){
    $text = urlencode($text);
    $searchWord = '%09%E5%90%8D%E8%A9%9E';
    $word = strstr($text, $searchWord, true);
    $noun = urldecode($word);
  return $noun;
}

function pickingProperNoun($text){
  $searchWord = '固有名詞';
  $properNoun = strstr($text, $searchWord, true);
  if ($properNoun){
    $properNoun = urlencode($properNoun);
    $brank = '%09';
    $word = strstr($properNoun, $brank, true);
    $properNoun = urldecode($word);
  } else {
    $properNoun = false;
  }
  return $properNoun;
}



$originTexts = file(__DIR__ . '/mophological.txt');
$result = pickingProperNoun($originTexts[0]);
$properNounsArray = array();
$pickingResult = '';
$pickingProperResult = '';

for ($i = 0; $i < count($originTexts); $i++){
  $pickingProperResult = pickingProperNoun($originTexts[$i]);
  $properNoun = '';
    #checking the continuous nous , and if it exist, putting together. 
  if ($pickingProperResult){
    $properNoun = $pickingProperResult;
    $pickingResult = pickingNoun($originTexts[++$i]);
    $pickingProperResult = false;
    while ($pickingResult || $pickingProperResult){
      if ($pickingProperResult){
        $properNoun = $properNoun . $pickingProperResult;
      } elseif ($pickingResult){
        $properNoun = $properNoun . $pickingResult;
      }
      $pickingResult = pickingNoun($originTexts[++$i]);
      $pickingProperResult = pickingProperNoun($originTexts[$i]);
    }
  }
    if (!$pickingResult){
      array_push($properNounsArray, $properNoun);
      $ProperNoun = '';
    }
}

$properNumber = array_count_values($properNounsArray);
$isRankingArray = arsort($properNumber, SORT_NUMERIC);
echo "最も関連度の高いワード<br>";
foreach ($properNumber as $val => $key){
  echo $key . " : " .$val . "<br>";
}
