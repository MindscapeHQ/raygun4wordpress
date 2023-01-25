<?php

namespace Mindscape\Raygun4Wordpress;

use Raygun4php\RaygunClient as BaseRaygunClient;
use Raygun4php\Interfaces\TransportInterface;

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
