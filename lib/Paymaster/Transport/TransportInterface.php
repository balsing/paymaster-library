<?php


namespace Paymaster\Transport;


use Paymaster\Request;
use Paymaster\Response;

interface TransportInterface
{
    public function request(Request $request): Response;
}
