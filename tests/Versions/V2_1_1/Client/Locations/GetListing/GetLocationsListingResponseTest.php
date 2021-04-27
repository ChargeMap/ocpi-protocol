<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Client\Locations\GetListing;

use Chargemap\OCPI\Common\Client\OcpiUnauthorizedException;
use Chargemap\OCPI\Versions\V2_1_1\Client\Locations\GetListing\GetLocationsListingRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Locations\GetListing\GetLocationsListingResponse;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories\LocationFactoryTest;

class GetLocationsListingResponseTest extends TestCase
{
    /**
     * @return mixed[][]
     */
    public function getFromData(): iterable
    {
        foreach (scandir(__DIR__ . '/payloads/Valid/') as $file) {
            if ($file !== '.' && $file !== '..') {
                yield $file => [
                    'payload' => file_get_contents(__DIR__ . '/payloads/Valid/' . $file),
                ];
            }
        }
    }

    /**
     * @param string $payload
     * @throws OcpiUnauthorizedException
     * @throws \JsonException
     * @dataProvider getFromData()
     */
    public function testWithDocumentationExamplePayload(string $payload): void
    {
        $json = json_decode( $payload, false, 512, JSON_THROW_ON_ERROR);

        $serverResponse = Psr17FactoryDiscovery::findResponseFactory()->createResponse(200)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('X-Total-Count', 1)
            ->withBody(
                Psr17FactoryDiscovery::findStreamFactory()->createStream($payload)
            );

        $locations = GetLocationsListingResponse::from((new GetLocationsListingRequest())
            ->withOffset(0)
            ->withLimit(10), $serverResponse)
            ->getLocations();

        foreach ($json->data as $index => $jsonLocation) {
            LocationFactoryTest::assertLocation($jsonLocation, $locations[$index]);
        }
    }

    public function testWith401Unauthorized(): void
    {
        $payload = file_get_contents(__DIR__ . '/payloads/Invalid/sample_401.html');

        $serverResponse = Psr17FactoryDiscovery::findResponseFactory()->createResponse(401)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('X-Total-Count', 1)
            ->withBody(
                Psr17FactoryDiscovery::findStreamFactory()->createStream($payload)
            );

        $this->expectException(OcpiUnauthorizedException::class);

        // first item of list
        GetLocationsListingResponse::from((new GetLocationsListingRequest())
            ->withOffset(0)
            ->withLimit(10), $serverResponse)
            ->getLocations()[0];
    }

    public function testWithPartialValidLocation(): void
    {
        $payload = file_get_contents(__DIR__ . '/payloads/PartialValid/locations.json');

        $serverResponse = Psr17FactoryDiscovery::findResponseFactory()->createResponse(200)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('X-Total-Count', 2)
            ->withBody(
                Psr17FactoryDiscovery::findStreamFactory()->createStream($payload)
            );

        $locations = GetLocationsListingResponse::from((new GetLocationsListingRequest())
            ->withOffset(0)
            ->withLimit(10), $serverResponse)
            ->getLocations();

        $this->assertCount(1,$locations);
    }
}
