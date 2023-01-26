<?php

namespace Raygun\Raygun4WP;

use Raygun4php\Interfaces\TransportInterface;
use Raygun4php\RaygunClient as BaseRaygunClient;

class RaygunClient extends BaseRaygunClient
{
    /**
     * Return the transport used.
     *
     * @return TransportInterface
     */
    public function getTransport(): TransportInterface
    {
        return $this->transport;
    }

    /**
     * Is the client asynchronous ?
     *
     * @return bool
     */
    public function isAsync(): bool
    {
        return method_exists($this->transport, 'wait');
    }
}
