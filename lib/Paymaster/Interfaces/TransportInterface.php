<?php


namespace Paymaster\Interfaces;


interface TransportInterface
{
    public function request(RequestInterface $request): ResponseInterface;

    public function setBearerToken(string $token): TransportInterface;
}
