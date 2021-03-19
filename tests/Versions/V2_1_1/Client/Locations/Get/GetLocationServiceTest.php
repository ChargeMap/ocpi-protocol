<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Client\Locations\Get;

use Chargemap\OCPI\Common\Client\OcpiUnauthorizedException;
use Chargemap\OCPI\Versions\V2_1_1\Client\Locations\Get\GetLocationRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Locations\Get\GetLocationResponse;
use Chargemap\OCPI\Versions\V2_1_1\Client\Locations\Get\GetLocationService;
use Http\Discovery\Psr17FactoryDiscovery;
use JsonException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Client\Locations\Get\GetLocationService
 */
class GetLocationServiceTest extends TestCase
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
     * @dataProvider validPayloadsProvider
     * @param string $payload
     * @throws OcpiUnauthorizedException
     * @throws JsonException
     */
    public function testHandle(string $payload): void
    {
        $service = $this->getMockBuilder(GetLocationService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['sendRequest'])
            ->getMock();

        $request = new GetLocationRequest('123');
        $serverResponse = Psr17FactoryDiscovery::findResponseFactory()->createResponse()
            ->withHeader('Content-Type', 'application/json')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($payload));

        $service->expects($this->once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($serverResponse);

        $response = $service->handle($request);
        $this->assertEquals(GetLocationResponse::from($serverResponse), $response);
    }
}
