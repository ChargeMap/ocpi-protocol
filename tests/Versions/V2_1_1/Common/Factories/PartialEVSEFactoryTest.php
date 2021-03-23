<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\PartialEVSEFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PartialEVSE;
use DateTime;
use JsonException;
use PHPUnit\Framework\TestCase;
use stdClass;
use Tests\Chargemap\OCPI\InvalidPayloadException;
use Tests\Chargemap\OCPI\OcpiTestCase;
use function PHPUnit\Framework\assertSame;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Common\Factories\PartialEVSEFactory
 */
class PartialEVSEFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/PartialEVSE/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/PartialEVSE/' . $filename),
                ];
            }
        }
    }

    /**
     * @param string $payload
     * @throws JsonException|InvalidPayloadException
     * @dataProvider getFromJsonData()
     */
    public function testFromJson(string $payload): void
    {
        $json = json_decode($payload, false, 512, JSON_THROW_ON_ERROR);

        OcpiTestCase::coerce('V2_1_1/eMSP/Server/Locations/Evses/evsePatchRequest.schema.json', $json);

        $evse = PartialEVSEFactory::fromJson($json);

        self::assertPartialEVSE($json, $evse);
    }

    public static function assertPartialEVSE(stdClass $json, PartialEVSE $evse): void
    {
        if (property_exists($json, 'uid')) {
            self::assertTrue($evse->hasUid());
            self::assertSame($json->uid, $evse->getUid());
        } else {
            self::assertFalse($evse->hasUid());
        }
        if (property_exists($json, 'evse_id')) {
            self::assertTrue($evse->hasEvseId());
            self::assertSame($json->evse_id, $evse->getEvseId());
        } else {
            self::assertFalse($evse->hasEvseId());
        }
        if (property_exists($json, 'status')) {
            self::assertTrue($evse->hasStatus());
            self::assertSame($json->status, $evse->getStatus()->getValue());
        } else {
            self::assertFalse($evse->hasStatus());
        }
        if (property_exists($json, 'status_schedule')) {
            self::assertTrue($evse->hasStatusSchedules());
            self::assertCount(count($json->status_schedule ?? []), $evse->getStatusSchedule());
        } else {
            self::assertFalse($evse->hasStatusSchedules());
        }
        if (property_exists($json, 'capabilities')) {
            self::assertTrue($evse->hasCapabilities());
            self::assertCount(count($json->capabilities ?? []), $evse->getCapabilities());
        } else {
            self::assertFalse($evse->hasCapabilities());
        }
        if (property_exists($json, 'connectors')) {
            self::assertTrue($evse->hasConnectors());
            self::assertCount(count($json->connectors), $evse->getConnectors());
        } else {
            self::assertFalse($evse->hasConnectors());
        }
        if (property_exists($json, 'floor_level')) {
            self::assertTrue($evse->hasFloorLevel());
            self::assertSame($json->floor_level, $evse->getFloorLevel());
        } else {
            self::assertFalse($evse->hasFloorLevel());
        }
        if (property_exists($json, 'coordinates')) {
            self::assertTrue($evse->hasCoordinates());
            GeoLocationFactoryTest::assertGeolocation($json->coordinates, $evse->getCoordinates());
        } else {
            self::assertFalse($evse->hasCoordinates());
        }
        if (property_exists($json, 'physical_reference')) {
            self::assertTrue($evse->hasPhysicalReference());
            assertSame($json->physical_reference, $evse->getPhysicalReference());
        } else {
            self::assertFalse($evse->hasPhysicalReference());
        }
        if (property_exists($json, 'directions')) {
            self::assertTrue($evse->hasDirections());
            self::assertCount(count($json->directions ?? []), $evse->getDirections());
        } else {
            self::assertFalse($evse->hasDirections());
        }
        if (property_exists($json, 'parking_restrictions')) {
            self::assertTrue($evse->hasParkingRestrictions());
            self::assertCount(count($json->parking_restrictions ?? []), $evse->getParkingRestrictions());
        } else {
            self::assertFalse($evse->hasParkingRestrictions());
        }
        if (property_exists($json, 'images')) {
            self::assertTrue($evse->hasImages());
            self::assertCount(count($json->images ?? []), $evse->getImages());
        } else {
            self::assertFalse($evse->hasImages());
        }
        if (property_exists($json, 'last_updated')) {
            self::assertTrue($evse->hasLastUpdated());
            self::assertEquals(new DateTime($json->last_updated), $evse->getLastUpdated());
        } else {
            self::assertFalse($evse->hasLastUpdated());
        }
    }
}
