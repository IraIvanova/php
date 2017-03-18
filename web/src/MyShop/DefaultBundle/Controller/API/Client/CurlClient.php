<?php

namespace  MyShop\DefaultBundle\Controller\API\Client;

class CurlClient
{
private $host;
public function __construct($host)
{
    $this->host = $host;
}

public function send($jsonDataString, $uri = "")
{
    $curl = curl_init($this->host . $uri);
    if ($curl === false) {
        throw new \Exception("Can't initialize curl lib");
    }

    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonDataString);

    $response = curl_exec($curl);
    echo $response;

    if ($response === false) {
        $message = curl_error($curl);
        throw new \Exception("Curl error:" . $message);
    }

    curl_close($curl);

    return $response;
}

}