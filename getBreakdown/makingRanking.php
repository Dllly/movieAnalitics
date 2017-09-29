<?php
$fp = fopen('mophological.txt', 'r');
while (!feof($fp)){
  $noun = false;
  if (empty($isCheckNoun)){
    $isCheckNoun = false;
  } else {
    if ($isCheckNoun){
      echo "<br>";
    }
  }
  $searchWord = '名詞';
  $firstLine = fgets($fp);
  $noun = strstr($firstLine, $searchWord, true);
  if ($noun){
    $isCheckNoun = true;
  #deleting space.
  $noun = urlencode($noun);
  $secondLine = fgets($fp);
  $searchWord = '%09';
  $word = strstr($noun, $searchWord, true);
  $firstLine = urldecode($word);
  echo $firstLine;
  } else {
    $isCheckNoun = false;
  }
}
fclose($fp);
