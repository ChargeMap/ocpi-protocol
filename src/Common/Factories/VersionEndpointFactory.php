<?php
declare(strict_types=1);

namespace Chargemap\OCPI\Common\Factories;

use Chargemap\OCPI\Common\Client\OcpiVersion;
use Chargemap\OCPI\Common\Models\VersionEndpoint;
use Http\Discovery\Psr17FactoryDiscovery;
use stdClass;

class VersionEndpointFactory
{
    public static function fromJson(?stdClass $json): ?VersionEndpoint
    {
        if($json === null) {
            return null;
        }

        return new VersionEndpoint(
            OcpiVersion::fromVersionNumber($json->version),
            Psr17FactoryDiscovery::findUriFactory()->createUri($json->url)
        );
    }
}