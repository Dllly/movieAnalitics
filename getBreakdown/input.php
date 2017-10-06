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


if(is_uploaded_file($_FILES['inputFile']['tmp_name'])){
  if(move_uploaded_file($_FILES['inputFile']['tmp_name'],"./".$_FILES['inputFile']['name'])){
    $fileName = $_FILES['inputFile']['name'];
    $isChangingFileName = rename($fileName, "input.vtt");

    if ($isChangingFileName) {
      $handle = @fopen("input.vtt", "r");
      $writeFile = @fopen("input.txt", "w");
      file_put_contents("./input.txt", '');    
      $fgetCounter = 1;

      if ($handle) {
        while (($isFgets = fgets($handle)) !== false){
          if ($fgetCounter % 4 ===1){
          file_put_contents("./input.txt", $isFgets, FILE_APPEND);    
          }
          $fgetCounter++;
        }
      }
    }else{
       echo "error name changing";
    }
  } else {
      echo "error file moving.";  
  }
}else{
  echo "file not uploaded.";
}
$isShellExec = shell_exec("sh ./mecab.sh");

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
