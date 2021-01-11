<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Put;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\GeoLocation;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Put\OcpiEmspLocationPutRequest;
use Tests\Chargemap\OCPI\OcpiTestCase;

class RequestConstructionTest extends OcpiTestCase
{
    public function validParametersProvider(): iterable
    {
        foreach (scandir(__DIR__ . '/payloads/') as $filename) {
            if (substr($filename, 0, 3) === 'ok_') {
                yield basename(substr($filename, 3), '.json') => [__DIR__ . '/payloads/' . $filename];
            }
        }
    }

    /**
     * @dataProvider validParametersProvider
     * @param string $filename
     */

    public function testShouldConstructRequestWithPayload(string $filename): void
    {
        $payload = json_decode( file_get_contents($filename), false, 512, JSON_THROW_ON_ERROR );

        $serverRequestInterface = $this->createServerRequestInterface($filename);

        $request = new OcpiEmspLocationPutRequest($serverRequestInterface, new LocationRequestParams('FR', 'TNM', $payload->id));

        $this->assertEquals('FR', $request->getCountryCode());
        $this->assertEquals('TNM', $request->getPartyId());
        $this->assertEquals($payload->id, $request->getLocationId());

        $location = $request->getLocation();
        $this->assertSame($payload->id, $location->getId());
        $this->assertSame($payload->type, $location->getLocationType()->getValue());
        $this->assertSame($payload->name, $location->getName());
        $this->assertSame($payload->address, $location->getAddress());
        $this->assertSame($payload->city, $location->getCity());
        $this->assertSame($payload->postal_code, $location->getPostalCode());
        $this->assertSame($payload->country, $location->getCountry());
        $this->assertEquals(new GeoLocation($payload->coordinates->latitude, $payload->coordinates->longitude), $location->getCoordinates());
        $this->assertCount(count($payload->related_locations ?? []), $location->getRelatedLocations());
        $this->assertCount(count($payload->directions ?? []), $location->getDirections());
        $this->assertCount(count($payload->evses), $location->getEvses());
        if (property_exists($payload, 'opening_times')) {
            $openingTimes = $payload->opening_times;
            if ($openingTimes === null) {
                $this->assertEmpty($location->getOpeningTimes());
            } else {
                if (property_exists($openingTimes, 'twentyfourseven')) {
                    $isTwentyFourSeven = $openingTimes->twentyfourseven;
                    //assertEquals to match cases 'null or false' and 'true'
                    $this->assertEquals($isTwentyFourSeven,
                        $location->getOpeningTimes()->isTwentyFourSeven());
                    if ($isTwentyFourSeven == false) {
                        // If 'twenty four seven' is null or set to false, regular hours must be set
                        $this->assertNotEmpty($location->getOpeningTimes()->getRegularHours());
                        $this->assertCount(
                            count($openingTimes->regular_hours),
                            $location->getOpeningTimes()->getRegularHours()
                        );
                    } else {
                        // Should be empty if 'twenty four seven' is true
                        $this->assertEmpty($location->getOpeningTimes()->getRegularHours());
                    }
                } else {
                    // If 'twenty four seven' is not provided, regular hours should be set
                    $this->assertNotEmpty($location->getOpeningTimes()->getRegularHours());
                    $this->assertCount(
                        count($openingTimes->regular_hours),
                        $location->getOpeningTimes()->getRegularHours()
                    );
                }
            }
        }
    }
}
