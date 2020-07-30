<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Patch;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Patch\OcpiEmspEvsePatchRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\GeoLocation;
use DateTime;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;

class RequestConstructionTest extends TestCase
{
    public function testShouldConstructRequestWithFullPayload(): void
    {
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('PATCH', 'randomUrl')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(
                file_get_contents(__DIR__ . '/payloads/EvsePatchFullPayload.json')
            ));

        $request = new OcpiEmspEvsePatchRequest($requestInterface, new LocationRequestParams('FR', 'TNM', 'LOC1', '3256'));
        $this->assertEquals('FR', $request->getCountryCode());
        $this->assertEquals('TNM', $request->getPartyId());
        $this->assertEquals('LOC1', $request->getLocationId());
        $this->assertEquals('3256', $request->getEvseUid());

        $evse = $request->getPartialEvse();
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

    public function testShouldConstructWithConnectors()
    {
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('PATCH', 'randomUrl')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(
                file_get_contents(__DIR__ . '/payloads/EvsePatchConnectorsPayload.json')
            ));

        $request = new OcpiEmspEvsePatchRequest($requestInterface, new LocationRequestParams('FR', 'TNM', 'LOC1', '3256'));
        $partialEvse = $request->getPartialEvse();
        $this->assertNull($partialEvse->getUid());
        $this->assertNull($partialEvse->getEvseId());
        $this->assertNotEmpty($partialEvse->getConnectors());
        $this->assertCount(2, $partialEvse->getConnectors());
        $connector1 = $partialEvse->getConnectors()[0];
        $this->assertEquals('1', $connector1->getId());
        $connector2 = $partialEvse->getConnectors()[1];
        $this->assertEquals('2', $connector2->getId());
    }

    public function testShouldConstructWithStatus()
    {
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('PATCH', 'randomUrl')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(
                file_get_contents(__DIR__ . '/payloads/EvsePatchStatusPayload.json')
            ));

        $request = new OcpiEmspEvsePatchRequest($requestInterface, new LocationRequestParams('FR', 'TNM', 'LOC1', '3256'));
        $partialEvse = $request->getPartialEvse();
        $this->assertNull($partialEvse->getUid());
        $this->assertNull($partialEvse->getEvseId());
        $this->assertEquals('AVAILABLE', $partialEvse->getStatus()->getValue());
    }
}
