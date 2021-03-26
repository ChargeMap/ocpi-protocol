<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Models;

use Chargemap\OCPI\Common\Client\OcpiVersion;
use Psr\Http\Message\UriInterface;

class VersionEndpoint
{
    private OcpiVersion $version;

    private UriInterface $uri;

    public function __construct(OcpiVersion $version, UriInterface $uri)
    {
        $this->version = $version;
        $this->uri = $uri;
    }

    public function getVersion(): OcpiVersion
    {
        return $this->version;
    }

    public function getUri(): UriInterface
    {
        return $this->uri;
    }
}
