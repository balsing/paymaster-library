<?php


namespace Paymaster;

use Paymaster\Transport\TransportInterface;

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

    public function __construct(TransportInterface $transport)
    {
        $this->transport = $transport;
    }
}
