<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Client\Locations\GetListing;

use Chargemap\OCPI\Versions\V2_1_1\Client\Locations\GetListing\GetLocationsListingRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Locations\GetListing\GetLocationsListingResponse;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;

class GetLocationsListingResponseTest extends TestCase
{
    public function testWithDocumentationExamplePayload(): void
    {
        $serverResponse = Psr17FactoryDiscovery::findResponseFactory()->createResponse(200)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('X-Total-Count', 1)
            ->withBody(
                Psr17FactoryDiscovery::findStreamFactory()->createStream(file_get_contents(__DIR__ . '/../payloads/location.json'))
            );

        // first item of list
        $location = GetLocationsListingResponse::from((new GetLocationsListingRequest())
            ->withOffset(0)
            ->withLimit(10), $serverResponse)
            ->getLocations()[0];

        $this->assertSame('LOC1', $location->getId());
        $this->assertSame('ON_STREET', $location->getLocationType()->getValue());
        $this->assertSame('Gent Zuid', $location->getName());
        $this->assertSame('F.Rooseveltlaan 3A', $location->getAddress());
    }
}
