<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client\Modules\Versions\GetDetails;

use Chargemap\OCPI\Common\Client\Modules\Versions\GetAvailableVersions\VersionEndpoint;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class GetVersionDetailRequest
{
    private VersionEndpoint $versionEndpoint;

    public function __construct(VersionEndpoint $versionEndpoint)
    {
        $this->versionEndpoint = $versionEndpoint;
    }

    public function getServerRequestInterface(ServerRequestFactoryInterface $serverRequestFactory, ?StreamFactoryInterface $streamFactory): ServerRequestInterface
    {
        return $serverRequestFactory->createServerRequest('GET', $this->versionEndpoint->getUri()->__toString());
    }
}
