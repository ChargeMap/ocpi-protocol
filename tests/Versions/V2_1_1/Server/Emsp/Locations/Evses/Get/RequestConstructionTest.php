<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Get;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Get\OcpiEmspEvseGetRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use Http\Discovery\Psr17FactoryDiscovery;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class RequestConstructionTest extends TestCase
{
    public function testShouldFailWithoutEvseUid(): void
    {
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('GET', 'randomUrl')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=');
        $this->expectException(InvalidArgumentException::class);
        new OcpiEmspEvseGetRequest($requestInterface, new LocationRequestParams('EN', 'PID', 'locationId'));
    }

    public function testShouldConstructWithValidRequest(): void
    {
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('GET', 'randomUrl')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=');
        $request = new OcpiEmspEvseGetRequest($requestInterface, new LocationRequestParams('EN', 'PID', 'locationId', 'evseUid'));
        $this->assertInstanceOf(OcpiEmspEvseGetRequest::class, $request);
        $this->assertEquals('evseUid', $request->getEvseUid());
    }
}
