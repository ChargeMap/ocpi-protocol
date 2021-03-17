<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Client\Locations\Get;

use Chargemap\OCPI\Common\Client\OcpiUnauthorizedException;
use Chargemap\OCPI\Versions\V2_1_1\Client\Locations\Get\GetLocationResponse;
use Http\Discovery\Psr17FactoryDiscovery;
use JsonException;
use PHPUnit\Framework\TestCase;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories\LocationFactoryTest;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Client\Locations\Get\GetLocationResponse
 */
class GetLocationResponseTest extends TestCase
{
    public function validPayloadsProvider(): iterable
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
     * @dataProvider validPayloadsProvider()
     * @param string $payload
     * @throws OcpiUnauthorizedException
     * @throws JsonException
     */
    public function testWithDocumentationExamplePayload(string $payload): void
    {
        $serverResponse = Psr17FactoryDiscovery::findResponseFactory()->createResponse()
            ->withHeader('Content-Type', 'application/json')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($payload));

        $location = GetLocationResponse::from($serverResponse)->getLocation();
        $json = json_decode($serverResponse->getBody()->__toString(), false, 512, JSON_THROW_ON_ERROR);

        LocationFactoryTest::assertLocation($json->data, $location);
    }

    public function testWith401Unauthorized(): void
    {
        $payload = file_get_contents(__DIR__ . '/payloads/Invalid/sample_401.html');

        $serverResponse = Psr17FactoryDiscovery::findResponseFactory()->createResponse(401)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($payload));

        $this->expectException(OcpiUnauthorizedException::class);

        GetLocationResponse::from($serverResponse);
    }

    public function testWith404(): void
    {
        $payload = file_get_contents(__DIR__ . '/payloads/Invalid/not_found.json');

        $serverResponse = Psr17FactoryDiscovery::findResponseFactory()->createResponse(404)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($payload));

        $this->assertNull(GetLocationResponse::from($serverResponse)->getLocation());
    }

    public function testWithEmptyBody(): void
    {
        $serverResponse = Psr17FactoryDiscovery::findResponseFactory()->createResponse()
            ->withHeader('Content-Type', 'application/json');

        $this->assertNull(GetLocationResponse::from($serverResponse)->getLocation());
    }
}
