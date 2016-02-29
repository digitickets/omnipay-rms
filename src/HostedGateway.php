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
            'callbackUrl' => '',
            'merchantId' => '',
            'signatureKey' => '',
        );
    }

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
     * Authorize an amount on the customer's card.
     *
     * @param array $options
     *
     * @return ResponseInterface|void
     */
    public function authorize(array $options = array())
    {

    }

    /**
     * Handle return from off-site gateways after authorization.
     *
     * @param array $options
     *
     * @return ResponseInterface|void
     */
    public function completeAuthorize(array $options = array())
    {

    }

    /**
     * Capture an amount you have previously authorized.
     *
     * @param array $options
     *
     * @return ResponseInterface|void
     */
    public function capture(array $options = array())
    {

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

    }

    /**
     * Refund an already processed transaction.
     *
     * @param array $options
     *
     * @return ResponseInterface|void
     */
    public function refund(array $options = array())
    {

    }

    /**
     * Generally can only be called up to 24 hours after submitting a transaction.
     *
     * @param array $options
     *
     * @return ResponseInterface|void
     */
    public function void(array $options = array())
    {

    }

    /**
     * Convert an incoming request from an off-site gateway to a generic notification object for further processing.
     */
    public function acceptNotification()
    {

    }

    /**
     * @param array $options
     *
     * @return ResponseInterface|void
     */
    public function createCard(array $options = array())
    {
        throw new BadMethodCallException;
    }

    /**
     * @param array $options
     *
     * @return ResponseInterface|void
     */
    public function updateCard(array $options = array())
    {
        throw new BadMethodCallException;
    }

    /**
     * @param array $options
     *
     * @return ResponseInterface|void
     */
    public function deleteCard(array $options = array())
    {
        throw new BadMethodCallException;
    }
}
