<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client\Modules\Versions\GetAvailableVersions;

use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class GetAvailableVersionsRequest
{
    private string $versionsUrl;

    public function __construct(string $versionsUrl)
    {
        $this->versionsUrl = $versionsUrl;
    }

    public function getServerRequestInterface(ServerRequestFactoryInterface $serverRequestFactory): ServerRequestInterface
    {
        return $serverRequestFactory->createServerRequest('GET', $this->versionsUrl);
    }
}
