<?php

namespace Paymaster;

use Paymaster\Interfaces\TransportInterface;

/**
 * Основной.
 *
 * Class Controller
 */
class Paymaster extends Methods
{
    /**
     * @var TransportInterface
     */
    protected $transport;

    /**
     * Paymaster constructor.
     *
     * @param TransportInterface $transport
     */
    public function __construct(TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    public function setBearerToken($token)
    {
        $this->transport->setBearerToken($token);
    }
}
