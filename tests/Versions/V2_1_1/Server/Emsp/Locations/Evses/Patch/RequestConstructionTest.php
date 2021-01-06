<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Patch;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\GeoLocation;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Patch\OcpiEmspEvsePatchRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use DateTime;
use stdClass;
use Tests\Chargemap\OCPI\OcpiTestCase;

class RequestConstructionTest extends OcpiTestCase
{
    /**
     * @return mixed[][]
     */
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
        $this->assertEquals('FR', $request->getCountryCode());
        $this->assertEquals('TNM', $request->getPartyId());
        $this->assertEquals('LOC1', $request->getLocationId());
        $this->assertEquals('3256', $request->getEvseUid());

        $evse = $request->getPartialEvse();
        if ($evse->getUid() !== null) {
            $this->assertEquals($json->uid, $evse->getUid());
        }
        if ($evse->getEvseId() !== null) {
            $this->assertEquals($json->evse_id, $evse->getEvseId());
        }
        if ($evse->getStatus() !== null) {
            $this->assertEquals($json->status, $evse->getStatus()->getValue());
        }
        if ($evse->getStatusSchedule() !== null) {
            $this->assertCount(count($json->status_schedule), $evse->getStatusSchedule());
            foreach ($evse->getStatusSchedule() as $index => $statusSchedule) {
                $this->assertEquals(new DateTime($json->status_schedule[$index]->period_begin), $statusSchedule->getPeriodBegin());
                $this->assertEquals(new DateTime($json->status_schedule[$index]->period_end), $statusSchedule->getPeriodEnd());
                $this->assertEquals($json->status_schedule[$index]->status, $statusSchedule->getStatus()->getValue());
            }
        }
        if ($evse->getDirections() !== null) {
            $this->assertCount(count($json->directions), $evse->getDirections());
            foreach ($evse->getDirections() as $index => $direction) {
                $this->assertEquals($json->directions[$index]->language, $direction->getLanguage());
                $this->assertEquals($json->directions[$index]->text, $direction->getText());
            }
        }
        if ($evse->getParkingRestrictions() !== null) {
            $this->assertCount(count($json->parking_restrictions), $evse->getParkingRestrictions());
            foreach ($evse->getParkingRestrictions() as $index => $parkingRestriction) {
                $this->assertEquals($json->parking_restrictions[$index], $parkingRestriction->getValue());
            }
        }
        if ($evse->getCoordinates() !== null) {
            $this->assertEquals(new GeoLocation($json->coordinates->latitude, $json->coordinates->longitude), $evse->getCoordinates());
        }
        if ($evse->getCapabilities() !== null) {
            $this->assertCount(count($json->capabilities), $evse->getCapabilities());
            foreach ($evse->getCapabilities() as $index => $capability) {
                $this->assertEquals($json->capabilities[$index], $capability);
            }
        }
        if ($evse->getConnectors() !== null) {
            self::assertConnectors($json, $request);
        }
        if ($evse->getPhysicalReference() !== null) {
            $this->assertEquals($json->physical_reference, $evse->getPhysicalReference());
        }
        if ($evse->getFloorLevel() !== null) {
            $this->assertEquals($json->floor_level, $evse->getFloorLevel());
        }
        if ($evse->getImages() !== null) {
            $this->assertCount(count($json->images), $evse->getImages());
        }
        if ($evse->getLastUpdated() !== null) {
            $this->assertEquals(new DateTime($json->last_updated), $evse->getLastUpdated());
        }
    }

    public static function assertConnectors(stdClass $json, OcpiEmspEvsePatchRequest $request)
    {
        $partialEvse = $request->getPartialEvse();
        self::assertCount(count($json->connectors), $partialEvse->getConnectors());

        foreach ($partialEvse->getConnectors() as $index => $value) {
            self::assertEquals($json->connectors[$index]->id, $value->getId());
        }
    }
}
