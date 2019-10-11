<?php


namespace Paymaster\Methods;


use Paymaster\Paymaster;
use Paymaster\Request;
use Paymaster\Transport;
use Exception;

abstract class Base
{
    protected $request;
    protected $url = null;
    protected $method = null;
    protected $data = null;
    /**
     * @var Transport
     */
    private $transport;

    public function __construct(Transport $transport)
    {
        $this->transport = $transport;
        $this->request = new Request();
    }

    public function setupRequest()
    {

        $url = $this->url;
        $method = $this->method;
        $data = $this->data;
        if (is_null($url)) {
            throw new Exception('Patch not specified');
        }

        if (is_null($method)) {
            throw new Exception('Method not specified');
        }

        $this->request->setUrl($url)->setMethod($method)->setData($data);

        return $this;
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
                function ($item)
                    {
                        return "{$item}";
                    },
                array_keys($replace)
            );
            $url = preg_replace($pattern, array_values($replace), $url);
        }

        return $this->baseUrl ? $this->baseUrl.$url : $url;
    }

    /**
     * @return Transport
     */
    public function getTransport(): Transport
    {
        return $this->transport;
    }
}
