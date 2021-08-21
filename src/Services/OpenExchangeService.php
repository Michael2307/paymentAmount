<?php

namespace App\Services;

use App\API\OpenExchangeAPI;

class OpenExchangeService extends BasicService
{
    private $paymentAmount;

    private static $EMPTY_REQUEST = 'You forgot about request JSON body!';

    public function getPaymentAmount ($request)
    {
        $result = [];

        if (empty($request)) {
            $this->message = self::$EMPTY_REQUEST;
            return $this;
        }

        $data = json_decode($request, true);

        $checkoutCurrency = $data['checkoutCurrency'];

        $exchangeAPI = new OpenExchangeAPI();

        foreach ($data['items'] as $item) {
            if ($item['currency'] != $checkoutCurrency) {
                $rates = $exchangeAPI->getRate($item['currency']);
                if (isset($rates['message'])) {
                   $this->message = $rates;
                   return $this;
                }
                $rate = $rates['rates'][$checkoutCurrency];
                $result[] = $item['price'] * $item['quantity'] * $rate;
            } else {
                $result[] = $item['price'] * $item['quantity'];
            }
        }

        $this->paymentAmount = round(array_sum($result), 2);

        $this->data = [
            'checkoutPrice' => $this->paymentAmount,
            'checkoutCurrency' => $data['checkoutCurrency'],
        ];

        return $this;
    }

}
