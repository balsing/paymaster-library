<?php

namespace Paymaster\Methods;

use Paymaster\Request;
use Paymaster\Interfaces\TransportInterface;
use Exception;

abstract class Base
{
    const BASE_URL = 'https://guarantee.money';
    protected $request;
    protected $url = null;
    protected $method = null;
    protected $data = null;
    protected $params = null;
    /**
     * @var TransportInterface
     */
    private $transport;
    private $baseUrl = '';

    public function __construct(TransportInterface $transport)
    {
        $this->transport = $transport;
        $this->request = new Request();
    }

    public function setupRequest()
    {
        $url = $this->url;
        $method = $this->method;
        $data = $this->data;
        $params = $this->params;
        if (is_null($url)) {
            throw new Exception('Patch not specified');
        }

        if (is_null($method)) {
            throw new Exception('Method not specified');
        }

        $this->request->setUrl($url)->setMethod($method)->setData($data)->setParams($params);
    }

    public function execute()
    {
        $this->setupRequest();

        return $this->getTransport()->request($this->request);
    }

    /**
     * @param string $url
     *
     * @return string
     */
    public function makePatch(string $url = '', ?array $replace = null)
    {
        if (!is_null($replace)) {
            $pattern = array_map(
                function ($item) {
                    return "/\{$item\}/";
                },
                array_keys($replace)
            );

            $url = preg_replace($pattern, array_values($replace), $url);
        }

        return $this->baseUrl.$url;
    }

    /**
     * @return TransportInterface
     */
    public function getTransport(): TransportInterface
    {
        return $this->transport;
    }
}
