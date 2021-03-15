<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Connectors\Patch;

use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Connectors\Patch\OcpiEmspConnectorPatchRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Patch\UnsupportedPatchException;
use Http\Discovery\Psr17FactoryDiscovery;
use Tests\Chargemap\OCPI\OcpiTestCase;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models\PartialConnectorTest;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Connectors\Patch\OcpiEmspConnectorPatchRequest
 */
class RequestConstructionTest extends OcpiTestCase
{
    public function validPayloadsProvider(): iterable
    {
        foreach (scandir(__DIR__ . '/payloads/valid/') as $filename) {
            if( $filename !== '.' && $filename !== '..') {
                yield basename($filename, '.json') => [
                    'filename' =>  __DIR__ . '/payloads/valid/' . $filename,
                ];
            }
        }
    }

    /**
     * @dataProvider validPayloadsProvider
     * @param string $filename
     * @throws UnsupportedPatchException
     */
    public function testShouldConstructRequestWithFullPayload(string $filename): void
    {
        $serverRequestInterface = $this->createServerRequestInterface($filename);

        $request = new OcpiEmspConnectorPatchRequest($serverRequestInterface, new LocationRequestParams('FR', 'TNM', 'LOC1', '3256', '1'));
        $this->assertEquals('FR', $request->getCountryCode());
        $this->assertEquals('TNM', $request->getPartyId());
        $this->assertEquals('LOC1', $request->getLocationId());
        $this->assertEquals('3256', $request->getEvseUid());
        $this->assertEquals('1', $request->getConnectorId());

        $connector = $request->getPartialConnector();
        PartialConnectorTest::assertJsonSerialization($connector, $request->getJsonBody());
    }

    public function invalidPayloadProvider(): array
    {
        return [
            "with empty body" => ["{}"],
            "with invalid url" => [json_encode(
                [
                    "terms_and_conditions" => "some_invalid_url"
                ]
            )]
        ];
    }

    /**
     * @dataProvider invalidPayloadProvider
     */
    public function testShouldFailWithInvalidPayload(string $payload): void
    {
        $serverRequestInterface = $this->createServerRequestInterface();
        $serverRequestInterface = $serverRequestInterface->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($payload));

        $this->expectException(OcpiInvalidPayloadClientError::class);
        new OcpiEmspConnectorPatchRequest($serverRequestInterface, new LocationRequestParams('FR', 'TNM', 'LOC1', '3256', '1'));
    }

    public function testShouldFailWithPatchId(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface(__DIR__ . '/payloads/valid/ConnectorPatchFullPayload.json');

        $this->expectException(UnsupportedPatchException::class);
        new OcpiEmspConnectorPatchRequest($serverRequestInterface, new LocationRequestParams('FR', 'TNM', 'LOC1', '3256', '2'));
    }
}
