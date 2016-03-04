<?php

namespace Omnipay\RetailMerchantServices\Message;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\RequestInterface;

class CompletePurchaseResponse extends AbstractRmsResponse
{
    /**
     * The embodied request object (type hint changed from parent).
     *
     * @var AbstractRmsRequest
     */
    protected $request;

    /**
     * Data sent back from RMS.
     *
     * @var array
     */
    protected $postData = [];

    /**
     * Response code from RMS.
     *
     * @var null
     */
    protected $code = null;

    /**
     * Response message from RMS.
     *
     * @var null
     */
    protected $message = null;

    /**
     * @var bool
     */
    protected $successful = false;

    /**
     * Transaction ID on gateway.
     *
     * @var null
     */
    protected $transactionReference = null;

    /**
     * Constructor
     *
     * @param RequestInterface $request the initiating request.
     * @param mixed            $data
     */
    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);

        $this->postData = $this->request->getHttpRequest()->request->all();
        $this->validate();
    }

    /**
     * Get the raw data returned from RMS.
     *
     * @return array
     */
    public function getPostData()
    {
        return $this->postData;
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->successful;
    }

    /**
     * @return null
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return null
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return null
     */
    public function getTransactionReference()
    {
        return $this->transactionReference;
    }

    /**
     * @return mixed
     */
    public function getTransactionId()
    {
        return $this->data['transactionId'];
    }

    /**
     * @return null
     */
    public function getAuthCode()
    {
        if (isset($this->postData['authorisationCode'])) {
            return $this->postData['authorisationCode'];
        }
        return null;
    }

    /**
     * Parse the RMS response, check if it is valid, and set code and message.
     *
     * @throws InvalidResponseException
     */
    protected function validate()
    {
        if (empty($this->postData)) {
            throw new InvalidResponseException("No data received from RMS.");
        }

        if (empty($this->postData['signature'])) {
            throw new InvalidResponseException("Response from RMS had no signature.");
        }

        $validSignature = $this->request->generateSignature($this->postData);
        if ($this->postData['signature'] !== $validSignature) {
            throw new InvalidResponseException("Response from RMS had invalid signature.");
        }

        // transactionReference is the Gateways's reference (Called transactionID on RMS)
        if (isset($this->postData['transactionID'])) {
            $this->transactionReference = $this->postData['transactionID'];
        }

        if (isset($this->postData['responseMessage'])) {
            $this->message = $this->postData['responseMessage'];
        }

        // Check the transactionId matches (Merchant's reference - transactionUnique on RMS)
        if (isset($this->data['transactionId']) &&
            !isset($this->postData['transactionUnique']) &&
            $this->data['transactionId'] != $this->postData['transactionUnique']
        ) {
            throw new InvalidResponseException(
                "Transaction IDs did not match.
            (Request: {$this->data['transactionId']} Response: {$this->postData['transactionUnique']})"
            );
        }

        // Check the payment status
        if (isset($this->postData['responseCode'])) {
            $this->code = $this->postData['responseCode'];
            $this->successful = $this->code === '0';
        } else {
            throw new InvalidResponseException("Response from RMS had no responseCode.");
        }
    }
}
