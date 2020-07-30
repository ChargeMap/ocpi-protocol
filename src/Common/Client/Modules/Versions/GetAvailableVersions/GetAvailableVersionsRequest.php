<?php

namespace Chargemap\OCPI\Common\Client\Modules\Versions\GetAvailableVersions;

use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;

class GetAvailableVersionsRequest
{
    private string $versionsUrl;

    public function __construct(string $versionsUrl)
    {
        $this->versionsUrl = $versionsUrl;
    }

    public function getRequestInterface(RequestFactoryInterface $requestFactory): RequestInterface
    {
        return $requestFactory->createRequest('GET', $this->versionsUrl);
    }
}
