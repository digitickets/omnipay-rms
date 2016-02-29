<?php

namespace Omnipay\RetailMerchantServices\Message;

use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * Class AuthorizeResponse
 *
 * @package Omnipay\RetailMerchantServices\Message
 */
class AuthorizeResponse extends AbstractRmsResponse implements RedirectResponseInterface
{
    /**
     * @return bool
     */
    public function isRedirect()
    {
        return true;
    }

    /**
     * @return string
     */
    public function getRedirectMethod()
    {
        return 'POST';
    }

    /**
     * @return mixed
     */
    public function getRedirectData()
    {
        return $this->getData();
    }

    /**
     * Gets the redirect target url.
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        return 'https://gateway.retailmerchantservices.co.uk/paymentform/';
    }
}
