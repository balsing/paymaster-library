<?php


namespace Paymaster\Interfaces;


interface ResponseInterface
{
    public function isSuccess();

    public function getCode();

    public function getData();

    public function getError();

    public function getErrorResourceKey();
}
