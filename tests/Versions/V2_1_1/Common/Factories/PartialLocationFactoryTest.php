<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\PartialLocationFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PartialLocation;
use DateTime;
use JsonException;
use PHPUnit\Framework\TestCase;
use Tests\Chargemap\OCPI\InvalidPayloadException;
use Tests\Chargemap\OCPI\OcpiTestCase;
use stdClass;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Common\Factories\PartialLocationFactory
 */
class PartialLocationFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/PartialLocation/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/PartialLocation/' . $filename),
                ];
            }
        }
    }

    /**
     * @param string $payload
     * @throws JsonException|InvalidPayloadException
     * @throws InvalidPayloadException
     * @dataProvider getFromJsonData()
     */
    public function testFromJson(string $payload): void
    {
        $json = json_decode($payload, false, 512, JSON_THROW_ON_ERROR);

        OcpiTestCase::coerce('V2_1_1/eMSP/Server/Locations/locationPatchRequest.schema.json', $json);

        $location = PartialLocationFactory::fromJson($json);

        self::assertPartialLocation($json, $location);
    }

    public static function assertPartialLocation(stdClass $json, PartialLocation $location): void
    {
        if (property_exists($json, 'id')) {
            self::assertTrue($location->hasId());
            self::assertSame($json->id, $location->getId());
        } else {
            self::assertFalse($location->hasId());
        }
        if (property_exists($json, 'type')) {
            self::assertTrue($location->hasLocationType());
            self::assertEquals($json->type, $location->getLocationType());
        } else {
            self::assertFalse($location->hasLocationType());
        }
        if (property_exists($json, 'name')) {
            self::assertTrue($location->hasName());
            self::assertSame($json->name, $location->getName());
        } else {
            self::assertFalse($location->hasName());
        }
        if (property_exists($json, 'address')) {
            self::assertTrue($location->hasAddress());
            self::assertSame($json->address, $location->getAddress());
        } else {
            self::assertFalse($location->hasAddress());
        }
        if (property_exists($json, 'city')) {
            self::assertTrue($location->hasCity());
            self::assertSame($json->city, $location->getCity());
        } else {
            self::assertFalse($location->hasCity());
        }
        if (property_exists($json, 'postal_code')) {
            self::assertTrue($location->hasPostalCode());
            self::assertSame($json->postal_code, $location->getPostalCode());
        } else {
            self::assertFalse($location->hasPostalCode());
        }
        if (property_exists($json, 'country')) {
            self::assertTrue($location->hasCountry());
            self::assertSame($json->country, $location->getCountry());
        } else {
            self::assertFalse($location->hasCountry());
        }
        if (property_exists($json, 'coordinates')) {
            self::assertTrue($location->hasCoordinates());
            GeoLocationFactoryTest::assertGeolocation($json->coordinates, $location->getCoordinates());
        } else {
            self::assertFalse($location->hasCoordinates());
        }
        if (property_exists($json, 'related_locations')) {
            self::assertTrue($location->hasRelatedLocations());
            self::assertCount(count($json->related_locations ?? []), $location->getRelatedLocations());
        } else {
            self::assertFalse($location->hasRelatedLocations());
        }
        if (property_exists($json, 'evses')) {
            self::assertTrue($location->hasEvses());
            self::assertCount(count($json->evses ?? []), $location->getEvses());
        } else {
            self::assertFalse($location->hasEvses());
        }
        if (property_exists($json, 'directions')) {
            self::assertTrue($location->hasDirections());
            self::assertCount(count($json->directions ?? []), $location->getDirections());
        } else {
            self::assertFalse($location->hasDirections());
        }
        if (property_exists($json, 'operator')) {
            self::assertTrue($location->hasOperator());
            BusinessDetailsFactoryTest::assertBusinessDetails($json->operator, $location->getOperator());
        } else {
            self::assertFalse($location->hasOperator());
        }
        if (property_exists($json, 'suboperator')) {
            self::assertTrue($location->hasSuboperator());
            BusinessDetailsFactoryTest::assertBusinessDetails($json->suboperator, $location->getSuboperator());
        } else {
            self::assertFalse($location->hasSuboperator());
        }
        if (property_exists($json, 'owner')) {
            self::assertTrue($location->hasOwner());
            BusinessDetailsFactoryTest::assertBusinessDetails($json->owner, $location->getOwner());
        } else {
            self::assertFalse($location->hasOwner());
        }
        if (property_exists($json, 'time_zone')) {
            self::assertTrue($location->hasTimeZone());
            self::assertSame($json->time_zone, $location->getTimeZone());
        } else {
            self::assertFalse($location->hasTimeZone());
        }
        if (property_exists($json, 'opening_times')) {
            self::assertTrue($location->hasOpeningTimes());
            HoursFactoryTest::assertHours($json->opening_times, $location->getOpeningTimes());
        } else {
            self::assertFalse($location->hasOpeningTimes());
        }
        if (property_exists($json, 'charging_when_closed')) {
            self::assertTrue($location->hasChargingWhenClosed());
            self::assertSame($json->charging_when_closed, $location->getChargingWhenClosed());
        } else {
            self::assertFalse($location->hasChargingWhenClosed());
        }
        if (property_exists($json, 'images')) {
            self::assertTrue($location->hasImages());
            self::assertCount(count($json->images ?? []), $location->getImages());
        } else {
            self::assertFalse($location->hasImages());
        }
        if (property_exists($json, 'energy_mix')) {
            self::assertTrue($location->hasEnergyMix());
            EnergyMixFactoryTest::assertEnergyMix($json->energy_mix, $location->getEnergyMix());
        } else {
            self::assertFalse($location->hasEnergyMix());
        }
        if (property_exists($json, 'last_updated')) {
            self::assertTrue($location->hasLastUpdated());
            self::assertEquals(new DateTime($json->last_updated), $location->getLastUpdated());
        } else {
            self::assertFalse($location->hasLastUpdated());
        }
    }
}
