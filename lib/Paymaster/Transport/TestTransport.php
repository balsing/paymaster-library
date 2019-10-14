<?php


namespace Paymaster\Transport;


use Paymaster\Interfaces\RequestInterface;
use Paymaster\Interfaces\ResponseInterface;
use Paymaster\Interfaces\TransportInterface;
use Paymaster\Response;

/**
 * Знает как сделать запрос
 *
 * Class Client
 * @package Paymaster
 */
class TestTransport implements TransportInterface
{
    public function request(RequestInterface $request): ResponseInterface
    {
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

    public function setBearerToken(string $token): TransportInterface
    {
        // TODO: Implement setBearerToken() method.
    }
}
