<?php
// This sample uses the Apache HTTP client from HTTP Components (http://hc.apache.org/httpcomponents-client-ga/)
$ch = curl_init();
$headers = array(
  "Content-Type: multipart/form-data",
  "Ocp-Apim-Subscription-Key:1fb39f00ae48491f81a35300aeaa690a"
);
$cfile = new CURLFile('/var/www/html/dev/movieAnalitics/upload/upload.mp4', 'video/mp4', 'uptest.mp4');
$fp = fopen('/var/www/html/dev/movieAnalitics/upload/curl.log', 'a');

  curl_setopt_array($ch, [ 
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_URL => 'https://videobreakdown.azure-api.net/Breakdowns/Api/Partner/Breakdowns?name=testUp&privacy=Private',
    CURLOPT_POST => true,
    CURLOPT_VERBOSE => true,
    CURLOPT_POSTFIELDS  => [
      'userfile[]' => new CURLFile('./upload.mp4'),
    ],
    CURLOPT_STDERR => $fp,
    #[
    # 'status'  => ' ',
     #'media[]' => new CURLFile('upload.mp4'),
    #],
  ]);
curl_exec($ch);
/*$data = array(
  'file'=>'@./upload.mp4;type=video/mp4'
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

curl_setopt($ch, CURLOPT_URL,'https://videobreakdown.azure-api.net/Breakdowns/Api/Partner/Breakdowns?name=testUp&privacy=Private');
#?name=testUp&privacy=Private');
$result = curl_exec($ch);
echo 'RETURN:'.$result;
curl_close($ch);
 */



#/ Request body
//$httpBody = file_get_contents('php://input');
//$httpBody = "var content = new MultipartFormDataContent(); content.Add(new StreamContent(File.Open(\"/var/www/html/dev/movieAnalitics/upload/upload.mp4\", FileMode.Open)), \"test\", \"filename\");";
//$request->setBody($httpBody);


?>
