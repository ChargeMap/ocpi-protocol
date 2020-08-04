<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Get;

use Chargemap\OCPI\Common\Server\StatusCodes\OcpiSuccessHttpCode;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\LocationFactory;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Get\OcpiEmspLocationGetResponse;
use DateTime;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;

class ResponseConstructionTest extends TestCase
{
    public function testShouldSerializeLocationCorrectlyWithFullPayload()
    {
        $location = LocationFactory::fromJson(json_decode(file_get_contents(__DIR__ . '/payloads/LocationPutFullPayload.json')));
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $response = new OcpiEmspLocationGetResponse($location);

        $responseInterface = $response->getResponseInterface($responseFactory, $streamFactory);
        $this->assertSame(OcpiSuccessHttpCode::HTTP_OK, $responseInterface->getStatusCode());
        $jsonLocation = json_decode($responseInterface->getBody()->getContents(), true)['data'];
        $this->assertSame('LOC1', $jsonLocation['id']);
        $this->assertSame('ON_STREET', $jsonLocation['type']);
        $this->assertSame('Gent Zuid', $jsonLocation['name']);
        $this->assertSame('F.Rooseveltlaan 3A', $jsonLocation['address']);
        $this->assertSame('Gent', $jsonLocation['city']);
        $this->assertSame('9000', $jsonLocation['postal_code']);
        $this->assertSame('BEL', $jsonLocation['country']);
        $this->assertSame([
            'latitude' => '3.729944',
            'longitude' => '51.047599'
        ], $jsonLocation['coordinates']);
        $this->assertCount(2, $jsonLocation['related_locations']);
        $this->assertSame([
            'latitude' => '3.729944',
            'longitude' => '51.047599',
            'name' => [
                'language' => 'en',
                'text' => 'Nice place'
            ]
        ], $jsonLocation['related_locations'][0]);
        $this->assertCount(2, $jsonLocation['evses']);
        $this->assertCount(2, $jsonLocation['directions']);
        $this->assertSame([
            'language' => 'en',
            'text' => 'Right'
        ], $jsonLocation['directions'][0]);
        $this->assertSame([
            'name' => 'BeCharged'
        ], $jsonLocation['operator']);
        $this->assertSame([
            'name' => 'BeCharged2'
        ], $jsonLocation['suboperator']);
        $this->assertSame([
            'name' => 'BeCharged3'
        ], $jsonLocation['owner']);
        $this->assertSame([
            'HOTEL', 'MUSEUM'
        ], $jsonLocation['facilities']);
        $this->assertSame('Europe/Paris', $jsonLocation['time_zone']);
        $this->assertSame([
            'exceptional_openings' => [
                [
                    'period_begin' => (new DateTime('2015-06-29T22:39:09Z'))->format(DateTime::ISO8601),
                    'period_end' => (new DateTime('2015-06-29T22:39:09Z'))->format(DateTime::ISO8601)
                ]
            ],
            'exceptional_closings' => [
                [
                    'period_begin' => (new DateTime('2015-06-29T22:39:09Z'))->format(DateTime::ISO8601),
                    'period_end' => (new DateTime('2015-06-29T22:39:09Z'))->format(DateTime::ISO8601)
                ]
            ],
            'twentyfourseven' => true
        ], $jsonLocation['opening_times']);
        $this->assertFalse($jsonLocation['charging_when_closed']);
        $this->assertCount(2, $jsonLocation['images']);
        $this->assertSame([
            'url' => 'https://google.com',
            'category' => 'NETWORK',
            'type' => 'jpeg',
            'thumbnail' => 'https://google.com',
            'width' => 455,
            'height' => 343
        ], $jsonLocation['images'][0]);
        $this->assertSame([
            'is_green_energy' => true,
            'energy_sources' => [
                [
                    'source' => 'NUCLEAR',
                    'percentage' => 50
                ],
                [
                    'source' => 'GAS',
                    'percentage' => 50
                ]
            ],
            'environ_impact' => [
                [
                    'source' => 'NUCLEAR_WASTE',
                    'amount' => 500
                ],
                [
                    'source' => 'CARBON_DIOXIDE',
                    'amount' => 1000
                ]
            ]
        ], $jsonLocation['energy_mix']);
        $this->assertEquals((new DateTime('2015-06-29T20:39:09Z'))->format(DateTime::ISO8601), $jsonLocation['last_updated']);
    }
}
