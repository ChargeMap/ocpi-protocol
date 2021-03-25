<?php
declare(strict_types=1);

namespace Chargemap\OCPI\Common\Factories;

use Chargemap\OCPI\Common\Client\OcpiModule;
use Chargemap\OCPI\Common\Client\OcpiVersion;
use Chargemap\OCPI\Common\Models\OcpiEndpoint;
use Http\Discovery\Psr17FactoryDiscovery;
use stdClass;

class OcpiEndpointFactory
{
    public static function fromJson(OcpiVersion $version, ?stdClass $json): ?OcpiEndpoint
    {
        if($json === null) {
            return null;
        }

        return new OcpiEndpoint(
            $version,
            new OcpiModule($json->identifier),
            Psr17FactoryDiscovery::findUriFactory()->createUri($json->url)
        );
    }
}