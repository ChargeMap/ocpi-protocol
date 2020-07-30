<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Put;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Put\OcpiEmspLocationPutRequest;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\GeoLocation;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;

class RequestConstructionTest extends TestCase
{
    public function testShouldConstructRequestWithPayload(): void
    {
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('PUT', 'randomUrl')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(
                file_get_contents(__DIR__ . '/payloads/LocationPutFullPayload.json')
            ));

        $request = new OcpiEmspLocationPutRequest($requestInterface, new LocationRequestParams('FR', 'TNM', 'LOC1'));
        $this->assertEquals('FR', $request->getCountryCode());
        $this->assertEquals('TNM', $request->getPartyId());
        $this->assertEquals('LOC1', $request->getLocationId());

        $location = $request->getLocation();
        $this->assertEquals('LOC1', $location->getId());
        $this->assertEquals('ON_STREET', $location->getLocationType()->getValue());
        $this->assertEquals('Gent Zuid', $location->getName());
        $this->assertEquals('F.Rooseveltlaan 3A', $location->getAddress());
        $this->assertEquals('Gent', $location->getCity());
        $this->assertEquals('9000', $location->getPostalCode());
        $this->assertEquals('BEL', $location->getCountry());
        $this->assertEquals(new GeoLocation("3.729944", "51.047599"), $location->getCoordinates());
        $this->assertCount(2, $location->getRelatedLocations());
        $this->assertCount(2, $location->getDirections());
        $this->assertCount(2, $location->getEvses());
    }
}
