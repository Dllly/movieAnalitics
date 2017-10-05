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


$originTexts = file(__DIR__ . '/mophological.txt');
$result = pickingNoun($originTexts[0]);
$nounsArray = array();

for ($i = 0; $i < count($originTexts); $i++){
  $pickingResult = pickingNoun($originTexts[$i]);
  $noun ='';


  #checking the continuous nous , and if it exist, putting together. 
  while ($pickingResult){
    $noun = $noun . $pickingResult;
    $pickingResult = pickingNoun($originTexts[++$i]);
    if (!$pickingResult){
      array_push($nounsArray, $noun);
      $noun = '';
    }
  }
}

# counting the number of occurences of each value in '$nounsArray'  
$countValues = array_count_values($nounsArray);

#sorting '$countValues' in ascending numbers.
$isRankingArray = arsort($countValues, SORT_NUMERIC);
foreach ($countValues as $key => $val){
  echo "$key = $val\n" . "<br>";
}
