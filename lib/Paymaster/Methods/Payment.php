<?php

namespace Paymaster\Methods;

class Payment
{
    public static function getUrl(array $data)
    {
        return Base::BASE_URL.'/card-payment?'.http_build_query($data);
    }
}
/*$data = [
    'userLogin' => 'userLogin',
'serviceLogin' => 'serviceLogin',
'contractId' => 'contractId',
'successReturnUrl' => 'successReturnUrl',
'failureReturnUrl' => 'failureReturnUrl',
'payment' => 'payment',
'sign' => 'sign',
];*/
