<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Patch;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Patch\OcpiEmspEvsePatchRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Patch\UnsupportedPatchException;
use DateTime;
use Tests\Chargemap\OCPI\OcpiTestCase;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories\ConnectorFactoryTest;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories\DisplayTextFactoryTest;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories\GeoLocationFactoryTest;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories\ImageFactoryTest;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories\StatusScheduleFactoryTest;

class RequestConstructionTest extends OcpiTestCase
{

    public function getJsonFilename(): iterable
    {
        foreach (scandir(__DIR__ . '/payloads') as $file) {
            if ($file !== '.' && $file !== '..') {
                yield $file => [
                    'payload' => __DIR__ . '/payloads/' . $file
                ];
            }
        }
    }

    /**
     * @param string $filename
     * @dataProvider getJsonFilename
     */
    public function testShouldConstructRequest(string $filename): void
    {
        $serverRequestInterface = $this->createServerRequestInterface($filename);
        $json = json_decode(file_get_contents($filename));

        $request = new OcpiEmspEvsePatchRequest($serverRequestInterface, new LocationRequestParams('FR', 'TNM', 'LOC1', '3256'));
        $this->assertSame('FR', $request->getCountryCode());
        $this->assertSame('TNM', $request->getPartyId());
        $this->assertSame('LOC1', $request->getLocationId());
        $this->assertSame('3256', $request->getEvseUid());

        $evse = $request->getPartialEvse();
        $this->assertSame($json->uid ?? null,$evse->getUid());
        $this->assertSame($json->evse_id ?? null, $evse->getEvseId());
        $this->assertEquals($json->status ?? null, $evse->getStatus());
        if (isset($json->status_schedule)) {
            $this->assertCount(count($json->status_schedule ?? []), $evse->getStatusSchedule());
            foreach ($evse->getStatusSchedule() as $index => $statusSchedule) {
                StatusScheduleFactoryTest::assertStatusSchedule($json->status_schedule[$index],$statusSchedule);
            }
        }
        if (isset($json->directions)) {
            $this->assertCount(count($json->directions ?? []), $evse->getDirections());
            foreach ($evse->getDirections() as $index => $direction) {
                DisplayTextFactoryTest::assertDisplayText($json->directions[$index],$direction);
            }
        }
        if (isset($json->parking_restrictions)) {
            $this->assertCount(count($json->parking_restrictions ?? []), $evse->getParkingRestrictions());
            foreach ($evse->getParkingRestrictions() as $index => $parkingRestriction) {
                $this->assertSame($json->parking_restrictions[$index], $parkingRestriction->getValue());
            }
        }

        GeoLocationFactoryTest::assertGeolocation($json->coordinates ?? null, $evse->getCoordinates());

        if (isset($json->capabilities)) {
            $this->assertCount(count($json->capabilities), $evse->getCapabilities());
            foreach ($evse->getCapabilities() as $index => $capability) {
                $this->assertEquals($json->capabilities[$index], $capability);
            }
        }

        if (isset($json->connectors)) {
            self::assertCount(count($json->connectors), $evse->getConnectors());
            foreach ($evse->getConnectors() as $index => $connector) {
                ConnectorFactoryTest::assertConnector($json->connectors[$index],$connector);
            }
        }

        $this->assertSame($json->physical_reference ?? null, $evse->getPhysicalReference());
        $this->assertSame($json->floor_level ?? null, $evse->getFloorLevel());

        if (isset($json->images)) {
            $this->assertCount(count($json->images ?? []), $evse->getImages());
            foreach ($evse->getImages() as $index => $image){
                ImageFactoryTest::assertImage($json->images[$index],$image);
            }
        }

        if (property_exists($json,'last_updated')) {
            if(($json->last_updated ?? null) === null){
                $this->assertNull($evse->getLastUpdated());
            } else {
                $this->assertEquals(new DateTime($json->last_updated), $evse->getLastUpdated());
            }
        }
    }

    public function testShouldFailWithPatchId(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface(__DIR__ . '/payloads/EvsePatchFullPayload.json');

        $this->expectException(UnsupportedPatchException::class);
        new OcpiEmspEvsePatchRequest($serverRequestInterface, new LocationRequestParams('FR', 'TNM', 'LOC1', '1'));
    }
}
