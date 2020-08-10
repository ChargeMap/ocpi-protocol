<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Get;

use Chargemap\OCPI\Common\Server\StatusCodes\OcpiSuccessHttpCode;
use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\EVSEFactory;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Get\OcpiEmspEvseGetResponse;
use DateTime;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;

class ResponseConstructionTest extends TestCase
{
    public function testShouldSerializeLocationCorrectlyWithFullPayload()
    {
        $evse = EVSEFactory::fromJson(json_decode(file_get_contents(__DIR__ . '/payloads/EvsePutFullPayload.json')));
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $response = new OcpiEmspEvseGetResponse($evse);

        $responseInterface = $response->getResponseInterface($responseFactory, $streamFactory);
        $this->assertSame(OcpiSuccessHttpCode::HTTP_OK, $responseInterface->getStatusCode());
        $jsonEvse = json_decode($responseInterface->getBody()->getContents(), true)['data'];
        $this->assertSame('3256', $jsonEvse['uid']);
        $this->assertSame('BE-BEC-E041503001', $jsonEvse['evse_id']);
        $this->assertSame('AVAILABLE', $jsonEvse['status']);
        $this->assertCount(2, $jsonEvse['status_schedule']);
        $this->assertSame([
                'period_begin' => (new DateTime('2014-06-24T00:00:00Z'))->format(DateTime::ISO8601),
                'period_end' => (new DateTime('2014-06-25T00:00:00Z'))->format(DateTime::ISO8601),
                'status' => 'INOPERATIVE'
            ]
            , $jsonEvse['status_schedule'][0]);
        $this->assertCount(2, $jsonEvse['directions']);
        $this->assertSame([
            'language' => 'en',
            'text' => 'Turn left'
        ], $jsonEvse['directions'][0]);
        $this->assertSame([
            'PLUGGED',
            'CUSTOMERS'
        ], $jsonEvse['parking_restrictions']);
        $this->assertSame([
            'latitude' => '3.729944',
            'longitude' => '51.047599'
        ], $jsonEvse['coordinates']);
        $this->assertSame(['RESERVABLE'], $jsonEvse['capabilities']);
        $this->assertCount(2, $jsonEvse['connectors']);
        $this->assertSame('1', $jsonEvse['physical_reference']);
        $this->assertSame('-1', $jsonEvse['floor_level']);
        $this->assertCount(2, $jsonEvse['images']);
        $this->assertSame([
            'url' => 'https://google.com',
            'category' => 'NETWORK',
            'type' => 'jpeg',
            'thumbnail' => 'https://google.com',
            'width' => 455,
            'height' => 343
        ], $jsonEvse['images'][0]);
        $this->assertEquals(DateTimeFormatter::format(new DateTime('2015-06-28T08:12:01Z')), $jsonEvse['last_updated']);
    }
}
