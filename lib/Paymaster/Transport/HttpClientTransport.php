<?php

namespace Paymaster\Transport;

use Paymaster\Interfaces\RequestInterface;
use Paymaster\Interfaces\TransportInterface;
use Paymaster\Interfaces\ResponseInterface;
use Paymaster\Response;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Знает как сделать запрос
 *
 * Class Client
 */
class HttpClientTransport implements TransportInterface
{
    /**
     * @var HttpClientInterface
     */
    private $client;
    private $token = null;

    public function __construct($token = null)
    {
        $this->client = HttpClient::create();

        if (!is_null($token)) {
            $this->token = $token;
        } else {
        }
    }

    public function request(RequestInterface $request): ResponseInterface
    {
        $params = [];
        if ($data = $request->getData()) {
            $params['json'] = $data;
        }
        if ($query = $request->getParams()) {
            $query = array_map(function ($item) {
                return htmlspecialchars($item);
            }, $query);
            $params['query'] = $query;
        }
        if (!is_null($this->token)) {
            $params['auth_bearer'] = $this->token;
        }
        var_export($request->getUrl());

        $response = $this->client->request(
            $request->getMethod(),
            $request->getUrl(),
            $params);

        var_export($response->toArray());

        return new Response($response->toArray());
    }

    /**
     * @param string $token
     *
     * @return TransportInterface
     */
    public function setBearerToken(string $token): TransportInterface
    {
        $this->token = $token;

        return $this;
    }
}
