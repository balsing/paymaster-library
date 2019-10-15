<?php

namespace Paymaster\Methods;

class Payment
{
    public function getUrl(array $data)
    {
        return Base::BASE_URL.'/card-payment?'.http_build_query($data);
    }
}
