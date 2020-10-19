<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Patch;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\GeoLocation;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Patch\OcpiEmspLocationPatchRequest;
use DateTime;
use Tests\Chargemap\OCPI\OcpiTestCase;

class RequestConstructionTest extends OcpiTestCase
{
    public function testShouldConstructRequestWithFullPayload(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface(__DIR__ . '/payloads/LocationPatchFullPayload.json');

        $request = new OcpiEmspLocationPatchRequest($serverRequestInterface, new LocationRequestParams('FR', 'TNM', 'LOC1'));

        $this->assertEquals('FR', $request->getCountryCode());
        $this->assertEquals('TNM', $request->getPartyId());
        $this->assertEquals('LOC1', $request->getLocationId());

        $location = $request->getPartialLocation();
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
        $this->assertEquals(new DateTime('2015-06-29T20:39:09Z'), $location->getLastUpdated());
    }

    public function testShouldConstructWithEVSEs(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface(__DIR__ . '/payloads/LocationPatchEvsesPayload.json');

        $request = new OcpiEmspLocationPatchRequest($serverRequestInterface, new LocationRequestParams('FR', 'TNM', 'LOC1'));
        $location = $request->getPartialLocation();
        $this->assertNull($location->getId());
        $this->assertNotNull($location->getEvses());
    }

    public function testShouldConstructWithOpeningTimes(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface(__DIR__ . '/payloads/LocationPatchOpeningTimesPayload.json');

        $request = new OcpiEmspLocationPatchRequest($serverRequestInterface, new LocationRequestParams('FR', 'TNM', 'LOC1'));
        $location = $request->getPartialLocation();
        $this->assertNull($location->getId());
        $this->assertNotEmpty($location->getOpeningTimes()->getExceptionalOpenings());
        $this->assertNotEmpty($location->getOpeningTimes()->getExceptionalClosings());
        $this->assertTrue($location->getOpeningTimes()->isTwentyFourSeven());
        $this->assertNotNull($location->getChargingWhenClosed());
        $this->assertFalse($location->getChargingWhenClosed());
    }
}
