<?php

namespace Chargemap\OCPI\Common\Client;

use Psr\Http\Message\UriInterface;

class OcpiEndpoint
{
    private OcpiVersion $protocolVersion;

    private OcpiModule $module;

    private UriInterface $uri;

    public function __construct(OcpiVersion $protocolVersion, OcpiModule $module, UriInterface $url)
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

    public function getUri(): UriInterface
    {
        return $this->uri;
    }
}
