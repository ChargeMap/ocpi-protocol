<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Put;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\GeoLocation;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Put\OcpiEmspLocationPutRequest;
use Tests\Chargemap\OCPI\OcpiTestCase;

class RequestConstructionTest extends OcpiTestCase
{
    public function testShouldConstructRequestWithPayload(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface(__DIR__ . '/payloads/LocationPutFullPayload.json');

        $request = new OcpiEmspLocationPutRequest($serverRequestInterface, new LocationRequestParams('FR', 'TNM', 'LOC1'));
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
