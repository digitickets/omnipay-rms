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
     * Get the URL to which the transaction details will be posted after the payment
     * process is complete.
     *
     * @return string
     */
    public function getCallbackUrl()
    {
        return $this->getParameter('callbackUrl');
    }

    /**
     * Set the URL to which the transaction details will be posted after the payment
     * process is complete.
     *
     * @param string $value
     *
     * @return self
     */
    public function setCallbackUrl($value)
    {
        return $this->setParameter('callbackUrl', $value);
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

        var_dump($signatureKey);

        ksort($data);

        var_dump($data);

        $str = http_build_query($data, '', '&');
        $str = str_replace(array('%0D%0A', '%0A%0D', '%0D'), '%0A', $str);
        $str .= $signatureKey;

        var_dump($str);

        $signature = hash('SHA512', $str);

        var_dump($signature);

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
