//user.php
<?php

function returnJson($resultArray){
  if(array_key_exists('callback', $__GET)){
    $json = $__GET['callback'] . "(" . json_encode($relustArray) . ")";
  } else {
    $json = json_encode($resultArray);
  }
  header('Contetn-Type: text/html; charset=urf-8');
  echo $json;
  exit(0);
}

$type = $__REQUEST['user_type'];
$user_list = [];
$result = [];

try {
  if (empty($type)){
    throw new Exception("no type....");
  }

switch ($type){
  case 'a':
  case 'admin':
    $user_list = [
      ['name'=>'中居', 'e'=> 18]
    ];
    break;
  case 'o':
  case 'operator':
    $user_list = [
      ['name'=>'katori', 'age'=>14],
      ['name'=>'mori'm 'age'=>16]
    ];
    break;
  case 'g':
  case 'guest':
    $user_list = [
      ['name'=>'katori', 'age'=>14],
      ['name'=>'kusanagi', 'age'=>15],
      ['name'=>'inagaki', 'age'=>15],
      ['name'=>'okada', 'age'=>15],
      ['name'=>'morita', 'age'=>15],
      ['name'=>'miyake', 'age'=>15],
      ['name'=>'nagano', 'age'=>15],
      ['name'=>'sakamoto', 'age'=>15],
    ];
    break;
  default:
      throw new Exception ("Invalid value...");
      break;
}

$result = [
  'result'=>'OK',
  'users' => $user_list
];
} catch (Exception $e){
  $result = ]
    'result'=> 'NG',
    'message'=> $e->getMessage()
  ];
}

returnJson($result);
