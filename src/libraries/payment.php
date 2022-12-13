<?php

namespace Phpay360\Libraries;

use Phpay360\config\Config;

class Payment extends Config
{

    public function getLink($payment_amount, $description = "")
    {
        $payment_amount = number_format($payment_amount, 2, '.', '');
        $data = [
            'session' => [
                'returnUrl' => [
                    'url' => $this->returnUrl
                ]
            ],
            'transaction' => [
                'description' => $description,
                'merchantReference' => $this->merchantReference,
                'money' => [
                    'amount' => [
                        'fixed' => $payment_amount
                    ],
                    'currency' => 'GBP'
                ],
                'commerceType' => 'ECOM',
                'channel' => 'WEB'
            ]
        ];
        try {
            $url = $this->{($this->type == 0 ? 'test' : 'prod') . '_url'} . '/hosted/rest/sessions/' . $this->merchantKey . '/payments';
            $return = $this->call($url, $data);
        } catch (\Exception $e) {
            $return = array(
                "status" => 0,
                "data" => array(
                    "outcome" => array(
                        "status" => "FAILED",
                        "reasonCode" => 'E0',
                        "reasonMessage" => $e->getMessage(),
                    ),
                ),
            );
        }
        return $return;
    }

    private function getHeaders()
    {

        $basic_auth = base64_encode($this->username . ':' . $this->password);

        return array(
            'Authorization: Basic ' . $basic_auth . '',
            'Content-Type: application/json',
        );
    }
    protected function call($url, $data)
    {

        $array = array(
            'CURLOPT_URL' => $url,
            'CURLOPT_RETURNTRANSFER' => true,
            'CURLOPT_ENCODING' => 'UTF-8',
            'CURLOPT_MAXREDIRS' => 10,
            'CURLOPT_TIMEOUT' => 0,
            'CURLOPT_FOLLOWLOCATION' => true,
            'CURLOPT_HTTP_VERSION' => CURL_HTTP_VERSION_1_1,
            'CURLOPT_CUSTOMREQUEST' => $this->method,
            'CURLOPT_HTTPHEADER' => $this->getHeaders(),
        );

        $array['CURLOPT_POSTFIELDS'] = json_encode($data);

        $curl = curl_init();

        curl_setopt_array($curl, $array);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $return = array(
                "status" => 0,
                "data" => array(
                    "error_no" => curl_errno($curl),
                    "message" => curl_error($curl),
                ),
            );
        } else {
            $return = array(
                "status" => 1,
                "data" => json_decode($response, true),
            );
        }

        curl_close($curl);

        return $return;
    }
}
