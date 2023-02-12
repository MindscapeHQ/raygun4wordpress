<?php

namespace Raygun\Raygun4WP;

use Raygun4php\Interfaces\TransportInterface;
use Raygun4php\RaygunClient as BaseRaygunClient;

// RaygunClient wrapper provides protected field access
class RaygunClient extends BaseRaygunClient {
    /**
     * Return a new copy of this client with new constructor arguments applied
     *
     * @param TransportInterface $transport
     * @param bool $userTracking
     *
     * @return RaygunClient
     */
    public function constructNew(TransportInterface $transport, bool $userTracking = true): RaygunClient {
        $newClient = new RaygunClient($transport, !$userTracking);
        $newClient->SetUser(
            $this->user,
            $this->firstName,
            $this->fullName,
            $this->email,
            $this->isAnonymous,
            $this->uuid
        );
        $newClient->setUserIdentifier($this->userIdentifier);
        $newClient->SetVersion($this->version);
        $newClient->SetGroupingKey($this->groupingKeyCallback);
        $newClient->setFilterParams($this->filterParams);
        $newClient->setFilterAllFormValues($this->filterAllFormValues);
        return $newClient;
    }

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
