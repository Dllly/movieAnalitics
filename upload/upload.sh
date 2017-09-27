#uuencode input.mp4 inputAscii > inputAscii.txt
#inputAscii=`cat inputAscii.txt`

#echo $inputAscii.txt | curl -v -X POST "https://videobreakdown.azure-api.net/Breakdowns/Api/Partner/Breakdowns?name=UploadingTest&privacy=Private&language=Japanese" -H "Content-Type: multipart/alternative" -H "Ocp-Apim-Subscription-Key: 1fb39f00ae48491f81a35300aeaa690a"  --data-ascii {@-}

#cat input.mp4 | curl -v -X POST "https://videobreakdown.azure-api.net/Breakdowns/Api/Partner/Breakdowns?name=UploadingTest&privacy=Private&language=Japanese" -H "Content-Type: multipart/form-data" -H "Ocp-Apim-Subscription-Key: 1fb39f00ae48491f81a35300aeaa690a"  --data-ascii @-

#curl -F 'file=@upload.mp4' https://videobreakdown.azure-api.net/Breakdowns/Api/Partner/Breakdowns
curl  -X POST -F "userid=1" -F "data=@upload.mp4"  -H "Ocp-Apim-Subscription-Key: 1fb39f00ae48491f81a35300aeaa690a" -H "Content-Type: multipart/form-data" https://videobreakdown.azure-api.net/Breakdowns/Api/Partner/Breakdowns?name=test&privacy=Private&language=Japanese
