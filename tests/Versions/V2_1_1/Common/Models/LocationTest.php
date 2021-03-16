<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Location;
use PHPUnit\Framework\Assert;
use stdClass;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Common\Models\Location
 */
class LocationTest
{
    public static function assertJsonSerialization(?Location $location, ?stdClass $json): void
    {
        if ($location === null) {
            Assert::assertNull($json);
        } else {
            Assert::assertSame($location->getId(), $json->id);
            Assert::assertSame($location->getName(), $json->name);
            BusinessDetailsTest::assertJsonSerialization($location->getOperator(), $json->operator);
            BusinessDetailsTest::assertJsonSerialization($location->getOwner(), $json->owner);
            Assert::assertSame($location->getAddress(), $json->address);
            Assert::assertSame($location->getChargingWhenClosed(), $json->charging_when_closed);
            Assert::assertSame($location->getCity(), $json->city);
            GeoLocationTest::assertJsonSerialization($location->getCoordinates(), $json->coordinates);
            Assert::assertSame($location->getCountry(), $json->country);

            if (empty($location->getDirections())) {
                Assert::assertEmpty($json->directions);
            } else {
                foreach ($location->getDirections() as $index => $direction) {
                    DisplayTextTest::assertJsonSerialization($direction, $json->directions[$index]);
                }
            }

            EnergyMixTest::assertJsonSerialization($location->getEnergyMix(), $json->energy_mix);

            foreach ($location->getEvses() as $index => $evse) {
                EvseTest::assertJsonSerialization($evse, $json->evses[$index]);
            }

            if (empty($location->getFacilities())) {
                Assert::assertEmpty($json->facilities);
            } else {
                foreach ($location->getFacilities() as $index => $facility) {
                    Assert::assertSame($facility->getValue(), $json->facilities[$index]);
                }
            }

            if (empty($location->getImages())) {
                Assert::assertEmpty($json->images);
            } else {
                foreach ($location->getImages() as $index => $image) {
                    ImageTest::assertJsonSerialization($image, $json->images[$index]);
                }
            }

            Assert::assertSame(DateTimeFormatter::format($location->getLastUpdated()), $json->last_updated);
            Assert::assertSame($location->getLocationType()->getValue(), $json->type);
            HoursTest::assertJsonSerialization($location->getOpeningTimes(), $json->opening_times);
            Assert::assertSame($location->getPostalCode(), $json->postal_code);

            if (empty($location->getRelatedLocations())) {
                Assert::assertEmpty($json->related_locations);
            } else {
                foreach ($location->getRelatedLocations() as $index => $image) {
                    AdditionalGeoLocationTest::assertJsonSerialization($image, $json->related_locations[$index]);
                }
            }

            BusinessDetailsTest::assertJsonSerialization($location->getSuboperator(), $json->suboperator);
            Assert::assertSame($location->getTimeZone(), $json->time_zone);
        }
    }
}
