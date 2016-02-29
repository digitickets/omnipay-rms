<?php

use Omnipay\Omnipay;
use Omnipay\RetailMerchantServices\HostedGateway;

require dirname(__DIR__).'/vendor/autoload.php';

$config = require __DIR__.'/config.php';

/** @var HostedGateway $gateway */
$gateway = Omnipay::create('RetailMerchantServices_Hosted');

$gateway->setCallbackUrl($config['callbackUrl']);
$gateway->setMerchantId($config['merchantId']);
$gateway->setSignatureKey($config['signatureKey']);


//print_r($gateway);

// Send purchase request
$response = $gateway->purchase(
    [
        'amount' => '1000',
        'country' => 'GB',
        'currency' => 'GBP',
        'redirectUrl' => 'http://www.example.com',
    ]
)->send();


//print_r($response);

// Process response
if ($response->isSuccessful()) {

    // Payment was successful
    print_r($response);

} elseif ($response->isRedirect()) {

    // Redirect to offsite payment gateway
    $response->redirect();

} else {

    // Payment failed
    echo $response->getMessage();
}
