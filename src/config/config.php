<?php

namespace Phpay360\Config;
class Config {

    private $username               = "PAY360_USERNAME";
    private $password               = "PAY360_PASSWORD";

    private $merchantKey            = "PAY360_MERCHANTKEY";
    private $merchantReference      = "PAY360_MERCHANTREFERENCE";

    private $returnUrl              = "PAY360_RETURN_URL";
    
    private $prod_url               = "https://api.pay360.com/acceptor/rest/";
    private $test_url               = "https://api.mite.pay360.com/acceptor/rest/";

    private $type                   = 0; // test => 0, prod => 1

    public function setUsername($data=""){
        $this->username=(string)$data;
        return $this;
    }

    public function setPassword($data=""){
        $this->password=(string)$data;
        return $this;
    }

    public function setMerchantKey($data=""){
        $this->merchantKey=(string)$data;
        return $this;
    }

    public function setMerchantReference($data=0){
        $this->merchantReference=(int)$data;
        return $this;
    }

    public function setReturnUrl($data=""){
        $this->returnUrl = $data;
        return $this;
    }

    public function setType($data=0)
    {
        $this->type=(int)$data;
        return $this;
    }
}