<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\LocationFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\AdditionalGeoLocation;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\BusinessDetails;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Location;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\LocationType;
use DateTime;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

class LocationFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/Location/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/Location/' . $filename),
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

        $location = LocationFactory::fromJson($json);

        self::assertLocation($json, $location);
    }

    public static function assertLocation(?stdClass $json, ?Location $location): void
    {
        if($json === null ) {
            Assert::assertNull($location);
        } else {
            Assert::assertSame($json->id, $location->getId());
            Assert::assertSame($json->name, $location->getName());
            BusinessDetailsFactoryTest::assertBusinessDetails($json->operator ?? null, $location->getOperator());
            BusinessDetailsFactoryTest::assertBusinessDetails($json->owner ?? null, $location->getOwner());
            Assert::assertSame($json->address, $location->getAddress());
            Assert::assertSame($json->charging_when_closed ?? null, $location->getChargingWhenClosed());
            Assert::assertSame($json->city, $location->getCity());
            GeoLocationFactoryTest::assertGeolocation($json->coordinates, $location->getCoordinates());
            Assert::assertSame($json->country, $location->getCountry());

            if(!property_exists($json, 'directions') || $json->directions === null) {
                Assert::assertCount(0, $location->getDirections());
            } else {
                foreach($json->directions as $index => $direction) {
                    DisplayTextFactoryTest::assertDisplayText($direction, $location->getDirections()[$index]);
                }
            }

            EnergyMixFactoryTest::assertEnergyMix($json->energy_mix ?? null, $location->getEnergyMix());

            foreach($json->evses as $index => $evse) {
                EvseFactoryTest::assertEvse($evse, $location->getEvses()[$index]);
            }

            if(!property_exists($json, 'facilities') || $json->facilities === null) {
                Assert::assertCount(0, $location->getFacilities());
            } else {
                foreach($json->facilities as $index => $facility) {
                    Assert::assertEquals($facility, $location->getFacilities()[$index]);
                }
            }

            if(!property_exists($json, 'images') || $json->images === null) {
                Assert::assertCount(0, $location->getImages());
            } else {
                foreach($json->images as $index => $image) {
                    ImageFactoryTest::assertImage($image, $location->getImages()[$index]);
                }
            }

            Assert::assertEquals(new DateTime($json->last_updated), $location->getLastUpdated());
            Assert::assertEquals(new LocationType($json->type), $location->getLocationType());
            HoursFactoryTest::assertHours($json->opening_times ?? null, $location->getOpeningTimes());
            Assert::assertSame($json->postal_code, $location->getPostalCode());

            if(!property_exists($json, 'related_locations') || $json->related_locations === null) {
                Assert::assertCount(0, $location->getImages());
            } else {
                foreach ($json->related_locations as $index => $relatedLocation) {
                    AdditionalGeoLocationFactoryTest::assertAdditionalGeoLocation($relatedLocation, $location->getRelatedLocations()[$index]);
                }
            }

            BusinessDetailsFactoryTest::assertBusinessDetails($json->suboperator ?? null, $location->getSuboperator());
            Assert::assertSame($json->time_zone ?? null, $location->getTimeZone());
        }
    }

}