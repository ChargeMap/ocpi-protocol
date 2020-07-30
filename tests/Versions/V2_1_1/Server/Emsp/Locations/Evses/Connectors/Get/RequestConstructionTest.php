<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Connectors\Get;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Connectors\Get\OcpiEmspConnectorGetRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use Http\Discovery\Psr17FactoryDiscovery;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class RequestConstructionTest extends TestCase
{
    public function testShouldFailWithoutConnectorId(): void
    {
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('GET', 'randomUrl')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=');
        $this->expectException(InvalidArgumentException::class);
        new OcpiEmspConnectorGetRequest($requestInterface, new LocationRequestParams('EN', 'PID', 'locationId', 'evseUid'));
    }

    public function testShouldConstructWithValidRequest(): void
    {
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('GET', 'randomUrl')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=');
        $request = new OcpiEmspConnectorGetRequest($requestInterface,
            new LocationRequestParams('EN', 'PID', 'locationId', 'evseUid', 'connectorId'));
        $this->assertInstanceOf(OcpiEmspConnectorGetRequest::class, $request);
        $this->assertEquals('connectorId', $request->getConnectorId());
    }
}
