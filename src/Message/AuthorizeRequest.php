<?php

namespace Omnipay\RetailMerchantServices\Message;

/**
 * Class AuthorizeRequest
 *
 * @package Omnipay\RetailMerchantServices\Message
 */
class AuthorizeRequest extends AbstractRmsRequest
{
    /**
     * Get the data to send to RMS to begin a transaction.
     *
     * @return array
     */
    public function getData()
    {
        $this->validate('amount', 'currency', 'returnUrl');

        $amount = $this->getParameter('amount');

        // Convert decimal amount to integer.
        if (stripos($amount, '.') !== false) {
            $amount = $amount * 100;
        } else {
            $amount = $amount.'00';
        }

        $data = [
            'merchantID' => $this->getMerchantId(),
            'callbackURL' => $this->getNotifyUrl(),
            'countryCode' => $this->getCountryCode(),
            'action' => 'SALE',

            'redirectURL' => $this->getParameter('returnUrl'),
            'currency' => $this->getParameter('currency'),
            'amount' => $amount,

            'customerName' => $this->getParameter('cutomerName'),
            'customerName' => $this->getParameter('cutomerName'),

            //'orderRef' => $this->getDescription()
        ];

        if ($transactionId = $this->getTransactionId()) {
            $data['transactionUnique'] = $transactionId;
        }

        if ($description = $this->getDescription()) {
            $data['orderRef'] = $description;
        }

        $card = $this->getCard();

        if ($customerName = $card->getBillingName()) {
            $data['customerName'] = $customerName;
        }

        $customerAddress = implode(
            "\n",
            [
                $card->getBillingAddress1(),
                $card->getBillingAddress2(),
                $card->getBillingCity(),
                $card->getBillingState(),
                $card->getBillingCountry()
            ]
        );

        $customerAddress = trim(str_replace("\n\n", "\n", $customerAddress));

        if ($customerAddress) {
            $data['customerAddress'] = $customerAddress;
        }

        if ($customerPostcode = $card->getBillingPostcode()) {
            $data['customerPostcode'] = $customerPostcode;
        }

        if ($customerEmail = $card->getEmail()) {
            $data['customerEmail'] = $customerEmail;
        }


        $data['signature'] = $this->generateSignature($data);

        /*echo '<pre>';
        echo 'CARD';
        print_r($card);
        echo 'DATA';
        print_r($data);
        die();*/

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
