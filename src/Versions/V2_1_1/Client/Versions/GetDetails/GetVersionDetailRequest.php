<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Versions\GetDetails;

use Chargemap\OCPI\Common\Models\VersionEndpoint;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetVersionDetailRequest
{
    private VersionEndpoint $versionEndpoint;

    public function __construct(VersionEndpoint $versionEndpoint)
    {
        $this->versionEndpoint = $versionEndpoint;
    }

    public function getServerRequestInterface(ServerRequestFactoryInterface $serverRequestFactory): ServerRequestInterface
    {
        return $serverRequestFactory->createServerRequest('GET', $this->versionEndpoint->getUri()->__toString());
    }
}
