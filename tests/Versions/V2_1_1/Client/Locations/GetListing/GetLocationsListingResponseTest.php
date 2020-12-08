<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Client\Locations\GetListing;

use Chargemap\OCPI\Common\Client\OcpiUnauthorizedException;
use Chargemap\OCPI\Versions\V2_1_1\Client\Locations\GetListing\GetLocationsListingRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Locations\GetListing\GetLocationsListingResponse;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;

class GetLocationsListingResponseTest extends TestCase
{
    /**
     * @return mixed[][]
     */
    public function getFromData(): iterable
    {
        foreach (scandir(__DIR__ . '/../payloads/Valid/') as $file) {
            if ($file !== '.' && $file !== '..') {
                yield $file => [
                    'payload' => file_get_contents(__DIR__ . '/../payloads/Valid/' . $file),
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

        // first item of list
        $location = GetLocationsListingResponse::from((new GetLocationsListingRequest())
            ->withOffset(0)
            ->withLimit(10), $serverResponse)
            ->getLocations()[0];

        $this->assertSame($json->data[0]->id, $location->getId());
        $this->assertSame($json->data[0]->type, $location->getLocationType()->getValue());
        $this->assertSame($json->data[0]->name, $location->getName());
        $this->assertSame($json->data[0]->address, $location->getAddress());
    }

    public function testWith401Unauthorized(): void
    {
        $this->expectException(OcpiUnauthorizedException::class);

        $payload = file_get_contents(__DIR__ . '/../payloads/Invalid/sample_401.html');

        $serverResponse = Psr17FactoryDiscovery::findResponseFactory()->createResponse(401)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('X-Total-Count', 1)
            ->withBody(
                Psr17FactoryDiscovery::findStreamFactory()->createStream($payload)
            );

        // first item of list
        $location = GetLocationsListingResponse::from((new GetLocationsListingRequest())
            ->withOffset(0)
            ->withLimit(10), $serverResponse)
            ->getLocations()[0];
    }
}
