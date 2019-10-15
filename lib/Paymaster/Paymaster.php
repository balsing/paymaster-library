<?php

namespace Paymaster;

use Paymaster\Interfaces\TransportInterface;
use Paymaster\Transport\HttpClientTransport;
use Paymaster\Transport\TestTransport;

/**
 * Основной.
 *
 * Class Controller
 */
class Paymaster extends Methods
{
    const DEV_MODE = 'develop';
    /**
     * @var TransportInterface
     */
    protected $transport;

    /**
     * Paymaster constructor.
     *
     * @param TransportInterface|null $transport
     */
    public function __construct($mode = null)
    {
        if (self::DEV_MODE === $mode) {
            $this->transport = new TestTransport();
        } else {
            $this->transport = new HttpClientTransport();
        }
    }

    public function setBearerToken($token)
    {
        $this->transport->setBearerToken($token);
    }
}
