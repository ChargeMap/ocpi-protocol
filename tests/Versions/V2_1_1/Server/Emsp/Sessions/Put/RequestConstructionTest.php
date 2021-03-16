<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Put;

use Chargemap\OCPI\Common\Server\Errors\OcpiNotEnoughInformationClientError;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Put\OcpiEmspSessionPutRequest;
use Http\Discovery\Psr17FactoryDiscovery;
use Tests\Chargemap\OCPI\OcpiTestCase;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories\SessionFactoryTest;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Put\OcpiEmspSessionPutRequest
 */
class RequestConstructionTest extends OcpiTestCase
{
    public function validParametersProvider(): iterable
    {
        foreach (scandir(__DIR__ . '/payloads/valid/') as $filename) {
            if( $filename !== '.' && $filename !== '..') {
                yield basename($filename, '.json') => [
                    'payload' => file_get_contents( __DIR__ . '/payloads/valid/' . $filename ),
                ];
            }
        }
    }

    public function invalidParametersProvider(): iterable
    {
        foreach (scandir(__DIR__ . '/payloads/invalid/') as $filename) {
            if( $filename !== '.' && $filename !== '..') {
                yield basename($filename, '.json') => [
                    'payload' => file_get_contents(__DIR__ . '/payloads/invalid/' . $filename),
                ];
            }
        }
    }

    /**
     * @param string $payload
     * @dataProvider validParametersProvider()
     */
    public function testShouldConstructRequestWithPayload(string $payload): void
    {
        $serverRequestInterface = Psr17FactoryDiscovery::findServerRequestFactory()
            ->createServerRequest('GET', 'randomUrl')
            ->withQueryParams(['type' => 'rfid'])
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($payload));

        $request = new OcpiEmspSessionPutRequest($serverRequestInterface, 'FR', 'TNM', '101');

        $this->assertEquals('FR', $request->getCountryCode());
        $this->assertEquals('TNM', $request->getPartyId());
        $this->assertEquals('101', $request->getSessionId());

        SessionFactoryTest::assertSession($request->getJsonBody(), $request->getSession());
    }

    /**
     * @param string $payload
     * @dataProvider invalidParametersProvider()
     */
    public function testWithoutBody(string $payload): void
    {
        $serverRequestInterface = Psr17FactoryDiscovery::findServerRequestFactory()
            ->createServerRequest('GET', 'randomUrl')
            ->withQueryParams(['type' => 'rfid'])
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($payload));

        $this->expectException(OcpiNotEnoughInformationClientError::class);
        new OcpiEmspSessionPutRequest($serverRequestInterface, 'FR', 'TNM', '101');
    }
}
