<?php

include __DIR__.'/vendor/autoload.php';

use Paymaster\Paymaster;
use Paymaster\Transport;
use Paymaster\Methods\Authentication;

$paymaster = new Paymaster((new Transport()));

/** @var \Paymaster\Response $response */
$response = $paymaster->getProfile()->get()->execute();
if($response->isSuccess()){
    var_dump($response->getData());
}





