<?php
// This sample uses the Apache HTTP client from HTTP Components (http://hc.apache.org/httpcomponents-client-ga/)
require_once '../.journal-php/Request2.php';

$request = new Http_Request2('https://videobreakdown.azure-api.net/Breakdowns/Api/Partner/Breakdowns');
$url = $request->getUrl();

$headers = array(
    // Request headers
        'Content-Type' => 'multipart/form-data',
            'Ocp-Apim-Subscription-Key' => '1fb39f00ae48491f81a35300aeaa690a',
            );

$request->setHeader($headers);

$parameters = array(
    // Request parameters
    'name' => 'test',
    'privacy' => 'Private',
    //'videoUrl' => '{string}',
    //'language' => '{string}',
    //'externalId' => '{string}',
    //'metadata' => '{string}',
    //'description' => '{string}',
    //'partition' => '{string}',
    //'callbackUrl' => '{string}',
    //'indexingPreset' => '{string}',
    //'streamingPreset' => '{string}',
);

$url->setQueryVariables($parameters);

$request->setMethod(HTTP_Request2::METHOD_POST);

#/ Request body
//$httpBody = file_get_contents('php://input');
//$httpBody = "var content = new MultipartFormDataContent(); content.Add(new StreamContent(File.Open(\"/var/www/html/dev/movieAnalitics/upload/upload.mp4\", FileMode.Open)), \"test\", \"filename\");";
//$request->setBody($httpBody);

try
{
    $response = $request->send();
        echo $response->getBody();
        }
        catch (HttpException $ex)
        {
            echo $ex;
            }

?>
