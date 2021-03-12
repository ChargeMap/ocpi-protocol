<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\EVSEFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Capability;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\EVSE;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\EVSEStatus;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ParkingRestriction;
use DateTime;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

class EvseFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/EVSE/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/EVSE/' . $filename),
                ];
            }
        }
    }

    /**
     * @param string $payload
     * @throws \JsonException
     * @dataProvider getFromJsonData()
     */
    public function testFromJson(string $payload): void
    {
        $json = json_decode($payload, false, 512, JSON_THROW_ON_ERROR);

        $evse = EVSEFactory::fromJson($json);

        self::assertEvse($json, $evse);
    }

    public static function assertEvse(?stdClass $json, ?EVSE $evse): void
    {
        if($json === null) {
            Assert::assertNull($evse);
        } else {
            Assert::assertSame($json->uid, $evse->getUid());
            Assert::assertSame($json->evse_id, $evse->getEvseId());
            Assert::assertEquals(new DateTime($json->last_updated), $evse->getLastUpdated());

            if(!property_exists($json, 'images' ) || $json->images === null ) {
                Assert::assertCount(0, $evse->getImages());
            } else {
                foreach($json->images as $index => $image) {
                    ImageFactoryTest::assertImage($image, $evse->getImages()[$index]);
                }
            }

            if(!property_exists($json, 'directions' ) || $json->directions === null ) {
                Assert::assertCount(0, $evse->getDirections());
            } else {
                foreach($json->directions as $index => $direction) {
                    DisplayTextFactoryTest::assertDisplayText($direction, $evse->getDirections()[$index]);
                }
            }

            GeoLocationFactoryTest::assertGeolocation($json->coordinates ?? null, $evse->getCoordinates());

            if(!property_exists($json, 'capabilities' ) || $json->capabilities === null ) {
                Assert::assertCount(0, $evse->getCapabilities());
            } else {
                foreach($json->capabilities as $index => $capability) {
                    Assert::assertEquals(new Capability($capability), $evse->getCapabilities()[$index]);
                }
            }

            if(!property_exists($json, 'connectors' ) || $json->connectors === null ) {
                Assert::assertCount(0, $evse->getConnectors());
            } else {
                foreach($json->connectors as $index => $connector) {
                    ConnectorFactoryTest::assertConnector($connector, $evse->getConnectors()[$index]);
                }
            }

            Assert::assertSame($json->floor_level ?? null, $evse->getFloorLevel());

            if(!property_exists($json, 'parking_restrictions' ) || $json->parking_restrictions === null ) {
                Assert::assertCount(0, $evse->getParkingRestrictions());
            } else {
                foreach($json->parking_restrictions as $index => $parkingRestriction) {
                    Assert::assertEquals(new ParkingRestriction($parkingRestriction), $evse->getParkingRestrictions()[$index]);
                }
            }

            Assert::assertSame($json->physical_reference ?? null, $evse->getPhysicalReference());
            Assert::assertEquals(new EVSEStatus($json->status), $evse->getStatus());

            if(!property_exists($json, 'status_schedule' ) || $json->status_schedule === null ) {
                Assert::assertCount(0, $evse->getStatusSchedule());
            } else {
                foreach($json->status_schedule as $index => $statusSchedule) {
                    StatusScheduleFactoryTest::assertStatusSchedule($statusSchedule, $evse->getStatusSchedule()[$index]);
                }
            }
        }
    }
}