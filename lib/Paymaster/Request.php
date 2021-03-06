<?php

namespace Paymaster;

use Exception;
use Paymaster\Interfaces\RequestInterface;

/**
 * Класс, предоставляет собой единый интерфейс для отправления параметров.
 *
 * Class Request
 */
class Request implements RequestInterface
{
    public const GET = 'GET';
    public const POST = 'POST';
    public const PUT = 'PUT';
    public const DELETE = 'DELETE';

    private $data = [];
    private $params = [];
    private $url = '';
    private $method = self::GET;

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return Request
     */
    public function setUrl(string $url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array|null $data
     *
     * @return $this
     */
    public function setData(?array $data): Request
    {
        if (is_array($data)) {
            $this->data = $data;
        }

        return $this;
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return Request
     */
    public function addData(string $key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     *
     * @return $this
     *
     * @throws Exception
     */
    public function setMethod(string $method)
    {
        if (!in_array($method, $this->getAvailableMethods())) {
            $availableMethods = implode(', ', $this->getAvailableMethods());
            throw new Exception(
                "Method {$method} not available. Please, use one of the following: {$availableMethods}"
            );
        }
        $this->method = $method;

        return $this;
    }

    /**
     * @return array
     */
    protected function getAvailableMethods()
    {
        return [
            self::GET,
            self::POST,
            self::PUT,
            self::DELETE,
        ];
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param array|null $params
     *
     * @return Request
     */
    public function setParams(?array $params): Request
    {
        if (is_array($params)) {
            $this->params = $params;
        }

        return $this;
    }
}
