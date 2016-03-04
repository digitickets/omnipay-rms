<?php

namespace Omnipay\RetailMerchantServices\Message;

/**
 * Class CompletePurchaseRequest
 *
 * @package Omnipay\RetailMerchantServices\Message
 */
class CompletePurchaseRequest extends AbstractRmsRequest
{
    public function getData()
    {
        return $this->parameters->all();
    }
}
