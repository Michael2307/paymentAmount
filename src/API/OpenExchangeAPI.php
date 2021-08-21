<?php

namespace App\API;

class OpenExchangeAPI
{
    protected $api_url = "https://openexchangerates.org/api/";
    protected $api_secret_key = "cdc6dfaf4da843d08069edcc39090f2f";
    private static $API_ENDPOINT = "latest.json";
    private static $BASE_CURRENCY = "USD";

    protected function getHttpCall($url, $params = null, $timeOut = 60)
    {
        $data = null;
        if (! empty($params)) {
            $data = http_build_query($params);
        }

        $ch = curl_init($url.$data);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeOut);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result,true);
    }

    public function getRate($base = null)
    {
        $params = null;
        if (
            $base != self::$BASE_CURRENCY
        ) {
            $params = [
                'base' => $base,
            ];
        }

        $resp = $this->getHttpCall($this->api_url . self::$API_ENDPOINT . '?app_id=' . $this->api_secret_key, $params);
        if (! isset($resp['error'])) return $resp;
        else return array('result' => false, 'message' => 'Try next time!', 'description' => 'Requested rates for an unsupported base currency. (code: 101)');
    }
}
