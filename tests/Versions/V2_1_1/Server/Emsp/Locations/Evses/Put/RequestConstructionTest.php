<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Put;

use Chargemap\OCPI\Common\Server\Errors\OcpiNotEnoughInformationClientError;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Put\OcpiEmspEvsePutRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\GeoLocation;
use DateTime;
use Tests\Chargemap\OCPI\OcpiTestCase;

class RequestConstructionTest extends OcpiTestCase
{
    public function testShouldConstructRequestWithPayload(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface(__DIR__ . '/payloads/EvsePutFullPayload.json');

        $request = new OcpiEmspEvsePutRequest($serverRequestInterface, new LocationRequestParams('FR', 'TNM', 'LOC1', '3256'));
        $this->assertEquals('FR', $request->getCountryCode());
        $this->assertEquals('TNM', $request->getPartyId());
        $this->assertEquals('LOC1', $request->getLocationId());
        $this->assertEquals('3256', $request->getEvseUid());

        $evse = $request->getEvse();
        $this->assertEquals('3256', $evse->getUid());
        $this->assertEquals('BE-BEC-E041503001', $evse->getEvseId());
        $this->assertEquals('AVAILABLE', $evse->getStatus()->getValue());
        $this->assertCount(2, $evse->getStatusSchedule());
        $statusSchedule = $evse->getStatusSchedule()[0];
        $this->assertEquals(new DateTime('2014-06-24T00:00:00Z'), $statusSchedule->getPeriodBegin());
        $this->assertEquals(new DateTime('2014-06-25T00:00:00Z'), $statusSchedule->getPeriodEnd());
        $this->assertEquals('INOPERATIVE', $statusSchedule->getStatus()->getValue());
        $this->assertCount(2, $evse->getDirections());
        $direction = $evse->getDirections()[0];
        $this->assertEquals('en', $direction->getLanguage());
        $this->assertEquals('Turn left', $direction->getText());
        $this->assertEquals('PLUGGED', $evse->getParkingRestrictions()[0]->getValue());
        $this->assertEquals(new GeoLocation("3.729944", "51.047599"), $evse->getCoordinates());
        $this->assertEquals('RESERVABLE', $evse->getCapabilities()[0]);
        $this->assertCount(2, $evse->getConnectors());
        $this->assertEquals('1', $evse->getPhysicalReference());
        $this->assertEquals('-1', $evse->getFloorLevel());
        $this->assertCount(2, $evse->getImages());
        $this->assertEquals(new DateTime("2015-06-28T08:12:01Z"), $evse->getLastUpdated());
    }

    public function testShouldFailWithoutEvseId(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface(__DIR__ . '/payloads/EvsePutFullPayload.json');

        $this->expectException(OcpiNotEnoughInformationClientError::class);

        new OcpiEmspEvsePutRequest($serverRequestInterface, new LocationRequestParams('FR', 'TNM', 'LOC1'));
    }
}
