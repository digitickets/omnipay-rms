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

$gateway->completePurchase();
