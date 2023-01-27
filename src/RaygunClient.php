<?php

namespace Raygun\Raygun4WP;

use Raygun4php\Interfaces\TransportInterface;
use Raygun4php\RaygunClient as BaseRaygunClient;

// RaygunClient wrapper for protected field access
class RaygunClient extends BaseRaygunClient {
    /**
     * Get the transport being used by the client
     *
     * @return TransportInterface
     */
    public function getTransport(): TransportInterface {
        return $this->transport;
    }

    /**
     * Get the async state of the client
     *
     * @return bool
     */
    public function isAsync(): bool {
        return method_exists($this->transport, 'wait');
    }
}
