<?php


namespace Paymaster;

use Paymaster\Interfaces\TransportInterface;
use Paymaster\Transport\HttpClientTransport;

/**
 * Основной
 *
 * Class Controller
 * @package Paymaster
 */
class Paymaster extends Methods
{
    /**
     * @var TransportInterface|null
     */
    protected $transport = null;

    /**
     * Paymaster constructor.
     *
     * @param TransportInterface|null $transport
     */
    public function __construct(TransportInterface $transport = null)
    {
        $this->transport = is_null($transport) ? new HttpClientTransport(): $transport;
    }

    public function setBearerToken($token){
        $this->transport->setBearerToken($token);
    }
}
