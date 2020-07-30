<?php

namespace Chargemap\OCPI\Common\Client\Modules\Versions\GetDetails;

use Chargemap\OCPI\Common\Client\Modules\Versions\GetAvailableVersions\VersionEndpoint;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;

class GetVersionDetailRequest
{
    private VersionEndpoint $versionEndpoint;

    public function __construct(VersionEndpoint $versionEndpoint)
    {
        $this->versionEndpoint = $versionEndpoint;
    }

    public function getRequestInterface(RequestFactoryInterface $requestFactory): RequestInterface
    {
        return $requestFactory->createRequest('GET', $this->versionEndpoint->getUri()->__toString());
    }
}
