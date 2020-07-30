<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Get;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Get\OcpiEmspLocationGetRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;

class RequestConstructionTest extends TestCase
{
    public function testShouldConstructWithValidRequest(): void
    {
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('GET', 'randomUrl')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=');
        $request = new OcpiEmspLocationGetRequest($requestInterface, new LocationRequestParams('EN', 'PID', 'locationId'));
        $this->assertInstanceOf(OcpiEmspLocationGetRequest::class, $request);
        $this->assertEquals('EN', $request->getCountryCode());
        $this->assertEquals('PID', $request->getPartyId());
        $this->assertEquals('locationId', $request->getLocationId());
    }
}
