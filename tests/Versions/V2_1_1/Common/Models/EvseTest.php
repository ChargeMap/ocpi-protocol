<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\EVSE;
use PHPUnit\Framework\Assert;
use stdClass;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Common\Models\EVSE
 */
class EvseTest
{
    public static function assertJsonSerialization(?EVSE $evse, ?stdClass $json): void
    {
        if ($evse === null) {
            Assert::assertNull($json);
        } else {
            Assert::assertSame($evse->getUid(), $json->uid);
            Assert::assertSame($evse->getEvseId(), $json->evse_id);
            Assert::assertEquals(DateTimeFormatter::format($evse->getLastUpdated()), $json->last_updated);
            if (empty($evse->getImages())) {
                Assert::assertEmpty($json->images ?? null);
            } else {
                foreach ($evse->getImages() as $index => $image) {
                    ImageTest::assertJsonSerialization($image, $json->images[$index]);
                }
            }
            if (empty($evse->getDirections())) {
                Assert::assertEmpty($json->directions ?? null);
            } else {
                foreach ($evse->getDirections() as $index => $direction) {
                    DisplayTextTest::assertJsonSerialization($direction, $json->directions[$index]);
                }
            }
            GeoLocationTest::assertJsonSerialization($evse->getCoordinates(), $json->coordinates ?? null);
            if (empty($evse->getCapabilities())) {
                Assert::assertEmpty($json->capabilities ?? null);
            } else {
                foreach ($evse->getCapabilities() as $index => $capability) {
                    Assert::assertSame($capability->getValue(), $json->capabilities[$index]);
                }
            }
            if (empty($evse->getConnectors())) {
                Assert::assertEmpty($json->connectors ?? null);
            } else {
                foreach ($evse->getConnectors() as $index => $connector) {
                    ConnectorTest::assertJsonSerialization($connector, $json->connectors[$index]);
                }
            }
            Assert::assertSame($evse->getFloorLevel(), $json->floor_level);
            if (empty($evse->getParkingRestrictions())) {
                Assert::assertEmpty($json->parking_restrictions ?? null);
            } else {
                foreach ($evse->getParkingRestrictions() as $index => $parkingRestriction) {
                    Assert::assertSame($parkingRestriction->getValue(), $json->parking_restrictions[$index]);
                }
            }
            Assert::assertSame($evse->getPhysicalReference(), $json->physical_reference);
            Assert::assertSame($evse->getStatus()->getValue(), $json->status);
            if (empty($evse->getStatusSchedule())) {
                Assert::assertEmpty($json->status_schedule ?? null);
            } else {
                foreach ($evse->getStatusSchedule() as $index => $statusSchedule) {
                    StatusScheduleTest::assertJsonSerialization($statusSchedule, $json->status_schedule[$index]);
                }
            }
        }
    }
}
