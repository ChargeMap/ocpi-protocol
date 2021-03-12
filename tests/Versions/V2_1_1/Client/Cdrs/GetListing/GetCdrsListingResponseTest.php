<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Client\Cdrs\GetListing;

use Chargemap\OCPI\Versions\V2_1_1\Client\Cdrs\GetListing\GetCdrsListingRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Cdrs\GetListing\GetCdrsListingResponse;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories\CdrFactoryTest;

class GetCdrsListingResponseTest extends TestCase
{
    public function validPayloadsProvider(): iterable
    {
        foreach (scandir(__DIR__ . '/../payloads/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield basename($filename, '.json') => [__DIR__ . '/../payloads/' . $filename];
            }
        }
    }

    /**
     * @dataProvider validPayloadsProvider
     * @param string $filename
     */
    public function testWithDocumentationExamplePayload(string $filename): void
    {
        $payload = file_get_contents($filename);

        $json = json_decode($payload, false, 512, JSON_THROW_ON_ERROR);

        $serverResponse = Psr17FactoryDiscovery::findResponseFactory()->createResponse(200)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('X-Total-Count', 1)
            ->withBody(
                Psr17FactoryDiscovery::findStreamFactory()->createStream($payload)
            );

        $cdrs = GetCdrsListingResponse::from((new GetCdrsListingRequest())
            ->withOffset(0)
            ->withLimit(10), $serverResponse)
            ->getCdrs();

        foreach ($json->data as $index => $item) {
            CdrFactoryTest::assertCdr($item, $cdrs[$index]);
        }
    }
}
