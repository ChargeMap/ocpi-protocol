<?php

namespace Chargemap\OCPI\Common\Client\Modules\Versions\GetAvailableVersions;

use Chargemap\OCPI\Common\Client\OcpiVersion;
use League\Uri\Uri;

class VersionEndpoint
{
    private OcpiVersion $version;

    private Uri $uri;

    public function __construct(OcpiVersion $version, Uri $uri)
    {
        $this->version = $version;
        $this->uri = $uri;
    }

    public function getVersion(): OcpiVersion
    {
        return $this->version;
    }

    public function getUri(): Uri
    {
        return $this->uri;
    }
}
