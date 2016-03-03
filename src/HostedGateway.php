<?php

namespace Omnipay\RetailMerchantServices;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Exception\BadMethodCallException;
use Omnipay\Common\Message\ResponseInterface;

/**
 * Class HostedGateway
 *
 * @package Omnipay\RetailMerchantServices
 */
class HostedGateway extends AbstractGateway
{
    const MESSAGE_NAMESPACE = '\\Omnipay\\RetailMerchantServices\\Message\\';

    /**
     * @return string
     */
    public function getName()
    {
        return 'Retail Merchant Services';
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return array(
            'notifyUrl' => '',
            'countryCode' => 'GB',
            'merchantId' => '',
            'signatureKey' => '',
        );
    }

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

    /**
     * @return mixed
     */
    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    /**
     * Get the request notify URL.
     *
     * @return string
     */
    public function getNotifyUrl()
    {
        return $this->getParameter('notifyUrl');
    }

    /**
     * Sets the request notify URL.
     *
     * @param string $value
     * @return AbstractRequest Provides a fluent interface
     */
    public function setNotifyUrl($value)
    {
        return $this->setParameter('notifyUrl', $value);
    }

    /**
     * @return mixed
     */
    public function getSignatureKey()
    {
        return $this->getParameter('signatureKey');
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setSignatureKey($value)
    {
        return $this->setParameter('signatureKey', $value);
    }

    /**
     * Authorize and immediately capture an amount on the customer's card.
     *
     * @param array $options
     *
     * @return ResponseInterface|void
     */
    public function purchase(array $options = array())
    {
        return $this->createRequest(self::MESSAGE_NAMESPACE.'AuthorizeRequest', $options);
    }

    /**
     * Handle return from off-site gateways after purchase.
     *
     * @param array $options
     *
     * @return ResponseInterface|void
     */
    public function completePurchase(array $options = array())
    {
        return $this->createRequest(self::MESSAGE_NAMESPACE.'CompletePurchaseRequest', $options);
    }

    /**
     * Convert an incoming request from an off-site gateway to a generic notification object for further processing.
     */
    public function acceptNotification()
    {

    }

}
