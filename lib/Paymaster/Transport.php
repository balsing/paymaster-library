<?php


namespace Paymaster;


use Paymaster\Methods\Deals;
use Paymaster\Transport\TransportInterface;

/**
 * Знает как сделать запрос
 *
 * Class Client
 * @package Paymaster
 */
class Transport implements TransportInterface
{
    public function request(Request $request): Response
    {
        $request->getUrl();

        return new Response(
            [
                'IsSuccess'        => 'IsSuccess',
                'Code'             => 'Code',
                'Data'             => 'Data 123',
                'Error'            => 'Error',
                'ErrorResourceKey' => 'ErrorResourceKey',
            ]
        );
    }
}
