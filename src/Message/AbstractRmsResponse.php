<?php

namespace Omnipay\RetailMerchantServices\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Class AbstractRmsResponse
 *
 * @package Omnipay\RetailMerchantServices\Message
 */
abstract class AbstractRmsResponse extends AbstractResponse
{
    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return false;
    }
}
