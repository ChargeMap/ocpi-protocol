<?php

namespace Chargemap\OCPI\Common\Client;

use League\Uri\Uri;

class OcpiEndpoint
{
    private OcpiVersion $protocolVersion;

    private OcpiModule $module;

    private Uri $uri;

    public function __construct(OcpiVersion $protocolVersion, OcpiModule $module, Uri $url)
    {
        $this->protocolVersion = $protocolVersion;
        $this->module = $module;
        $this->uri = $url;
    }

    public function getProtocolVersion(): OcpiVersion
    {
        return $this->protocolVersion;
    }

    public function getModule(): OcpiModule
    {
        return $this->module;
    }

    public function getUri(): Uri
    {
        return $this->uri;
    }
}
