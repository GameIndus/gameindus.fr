<?php

class Paypal
{

    private $user;
    private $pwd;
    private $signature;
    private $endpoint = "https://api-3t.sandbox.paypal.com/nvp";

    public $errors = array();

    public function __construct($configuration)
    {
        $this->user = $configuration->user;
        $this->pwd = $configuration->password;
        $this->signature = $configuration->signature;

        if ($configuration->production) {
            $this->endpoint = str_replace('sandbox.', '', $this->endpoint);
        }
    }

    public function request($method, $params)
    {
        $params = array_merge($params, array(
            "METHOD" => $method,
            "VERSION" => "74.0",
            "USER" => $this->user,
            "SIGNATURE" => $this->signature,
            "PWD" => $this->pwd
        ));
        $params = http_build_query($params);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->endpoint,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $params,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_VERBOSE => true
        ));

        $res = curl_exec($curl);
        $resArray = array();

        parse_str($res, $resArray);

        if (curl_errno($curl)) {
            $this->errors = curl_error($curl);
            curl_close($curl);
            return false;
        } else {
            if ($resArray["ACK"] == "Success") {
                curl_close($curl);
                return $resArray;
            } else {
                $this->errors = $resArray;
                curl_close($curl);
                return false;
            }
        }
    }

}

?>