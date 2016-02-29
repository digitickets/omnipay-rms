<?php

namespace Omnipay\RetailMerchantServices\Message;

/**
 * Class AuthorizeRequest
 *
 * @package Omnipay\RetailMerchantServices\Message
 */
class AuthorizeRequest extends AbstractRmsRequest
{
    protected $endpoint = 'https://gateway.retailmerchantservices.co.uk/paymentform/';

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->getParameter('country');
    }

    /**
     * @param string $value
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setCountry($value)
    {
        return $this->setParameter('country', $value);
    }

    /**
     * @return mixed
     */
    public function getRedirectUrl()
    {
        return $this->getParameter('redirectUrl');
    }

    /**
     * @param string $value
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setRedirectUrl($value)
    {
        return $this->setParameter('redirectUrl', $value);
    }

    /**
     * Get the data to be sent to the gateway
     *
     * @return array
     */
    public function getData()
    {
        $this->validate('amount', 'currency', 'redirectUrl', 'country');

        $data = [
            'merchantID' => $this->getMerchantId(),
            'callbackURL' => $this->getCallbackUrl(),
            'action' => 'SALE',
            'redirectURL' => $this->getParameter('redirectUrl'),
            'currency' => $this->getParameter('currency'),
            'country' => $this->getParameter('country'),
            'amount' => $this->getParameter('amount'),
        ];

        $data['signature'] = $this->generateSignature($data);

        return $data;
    }

    /**
     * @param array $data
     *
     * @return AuthorizeResponse
     */
    protected function createResponse($data)
    {
        return $this->response = new AuthorizeResponse($this, $data);
    }
}
