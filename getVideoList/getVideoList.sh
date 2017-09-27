curl -v -X GET "https://videobreakdown.azure-api.net/Breakdowns/Api/Partner/Breakdowns/7818f569b4" -H "Ocp-Apim-Subscription-Key: 1fb39f00ae48491f81a35300aeaa690a" > test.json
less test.json | jq "." | less >> breakdown.json
