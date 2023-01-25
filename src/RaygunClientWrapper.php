<?php

namespace Raygun\Raygun4WP;

use Raygun4php\RaygunClient;
use Raygun4php\Interfaces\TransportInterface;

class RaygunClientWrapper extends RaygunClient
{
    /**
     * Creates a new RaygunClient instance.
     *
     * @param TransportInterface $transport
     * @param bool $userTracking
     */
    public function __construct(TransportInterface $transport, $userTracking = false)
    {
        parent::__construct($transport, !$userTracking); // userTracking becomes disableUserTracking
    }

    /**
     * Return the transport used.
     *
     * @return TransportInterface
     */
    public function getTransport(): TransportInterface
    {
        return $this->transport;
    }
}