<?php

function xiaomiCountry($imei)
{
    $curl = curl_init();

    curl_setopt_array($curl, [
    CURLOPT_URL => "https://buy.mi.co.id/id/registration",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "imei=" . $imei,
    CURLOPT_HTTPHEADER => [
        "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
        "Accept-Encoding: gzip, deflate, br",
        "Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7",
        "Cache-Control: max-age=0",
        "Connection: keep-alive",
        "Content-Length: 20",
        "Content-Type: application/x-www-form-urlencoded",
        "Host: buy.mi.co.id",
        "Origin: https://buy.mi.co.id",
        "Referer: https://buy.mi.co.id/id/registration",
        "Sec-Fetch-Dest: document",
        "Sec-Fetch-Mode: navigate",
        "Sec-Fetch-Site: same-origin",
        "Sec-Fetch-User: ?1",
        "Upgrade-Insecure-Requests: 1",
        "User-Agent: Mozilla/5.0 (Linux; Android 5.0; SM-G900P Build/LRX21T) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Mobile Safari/537.36",
        'sec-ch-ua: "Google Chrome";v="87", "\"Not;A\\Brand";v="99", "Chromium";v="87"',
        "sec-ch-ua-mobile: ?1"
    ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        preg_match_all('/<p><span class="info-type">Negara pembelian: <\/span><span>(.*)<\/span>/', $response, $imei_country);
        return $imei . " | " . $imei_country[1][0];
    }
}

if(isset($argv[1])){
    $list = explode("\r\n", file_get_contents($argv[1]));
    foreach($list as $imei){
        $ic = xiaomiCountry($imei);
        echo $ic . "\n";
        file_put_contents("result.txt", $ic ."\n", FILE_APPEND);
    }
}else{
    echo "php mi.php imei.txt";
}
