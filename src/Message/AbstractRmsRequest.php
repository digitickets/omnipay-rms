<?php

namespace Omnipay\RetailMerchantServices\Message;

use Omnipay\Common\Message\AbstractRequest;

/**
 * Class AbstractRmsRequest
 *
 * @package Omnipay\RetailMerchantServices\Message
 */
abstract class AbstractRmsRequest extends AbstractRequest
{
    /**
     * @return mixed
     */
    public function getCountryCode()
    {
        return $this->getParameter('countryCode');
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setCountryCode($value)
    {
        return $this->setParameter('countryCode', $value);
    }

    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    public function getSignatureKey()
    {
        return $this->getParameter('signatureKey');
    }

    public function setSignatureKey($value)
    {
        return $this->setParameter('signatureKey', $value);
    }

    protected function generateSignature($data)
    {
        if (isset($data['signature'])) {
            unset($data['signature']);
        }

        $signatureKey = $this->getSignatureKey();

        ksort($data);

        $str = http_build_query($data, '', '&');
        $str = str_replace(array('%0D%0A', '%0A%0D', '%0D'), '%0A', $str);
        $str .= $signatureKey;

        $signature = hash('SHA512', $str);

        return $signature;
    }

    public function sendData($data)
    {
        return $this->createResponse($data);
    }

    /**
     * Create a proper response based on the request.
     *
     * @param  array $data
     *
     * @return AbstractRmsResponse
     */
    protected function createResponse($data)
    {
        $requestClass = get_class($this);
        $responseClass = substr($requestClass, 0, -7).'Response';

        return $this->response = new $responseClass($this, $data);
    }
}
