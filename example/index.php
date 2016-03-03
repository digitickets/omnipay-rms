<?php

use Omnipay\Omnipay;
use Omnipay\RetailMerchantServices\HostedGateway;

require dirname(__DIR__).'/vendor/autoload.php';

$config = require __DIR__.'/config.php';

die(json_encode($config));

/** @var HostedGateway $gateway */
$gateway = Omnipay::create('RetailMerchantServices_Hosted');
$gateway->initialize($config);

print_r($gateway);

// Send purchase request
$response = $gateway->purchase(
    [
        'amount' => '10.00',
        'currency' => 'GBP',
        'returnUrl' => 'http://www.example.com',
        'transactionId' => '12345'
    ]
)->send();


print_r($response);
die();

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
