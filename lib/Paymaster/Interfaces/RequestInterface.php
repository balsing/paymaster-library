<?php

namespace Paymaster\Interfaces;

interface RequestInterface
{
    public function getUrl(): string;

    public function setUrl(string $url);

    public function getData(): array;

    public function setData(?array $data);

    public function addData(string $key, $value);

    public function getMethod(): string;

    public function setMethod(string $method);

    public function getParams(): array;

    public function setParams(?array $data);
}
