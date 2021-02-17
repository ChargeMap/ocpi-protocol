<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Connectors\Put;

use Chargemap\OCPI\Common\Server\Errors\OcpiNotEnoughInformationClientError;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Connectors\Put\OcpiEmspConnectorPutRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use Tests\Chargemap\OCPI\OcpiTestCase;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories\ConnectorFactoryTest;

class RequestConstructionTest extends OcpiTestCase
{
    public function validParametersProvider(): iterable
    {
        foreach (scandir(__DIR__ . '/payloads/') as $filename) {
            if( $filename !== '.' && $filename !== '..') {
                yield basename($filename, '.json') => [
                    'filename' =>  __DIR__ . '/payloads/' . $filename
                ];
            }
        }
    }

    /**
     * @param string $filename
     * @dataProvider validParametersProvider()
     */
    public function testShouldConstructRequestWithPayload(string $filename): void
    {
        $json = json_decode(file_get_contents($filename));
        $serverRequestInterface = $this->createServerRequestInterface($filename);

        $request = new OcpiEmspConnectorPutRequest($serverRequestInterface, new LocationRequestParams('FR', 'TNM', 'LOC1', '3256', '1'));
        $this->assertEquals('FR', $request->getCountryCode());
        $this->assertEquals('TNM', $request->getPartyId());
        $this->assertEquals('LOC1', $request->getLocationId());
        $this->assertEquals('3256', $request->getEvseUid());
        $this->assertEquals('1', $request->getConnectorId());

        ConnectorFactoryTest::assertConnector($json,$request->getConnector());
    }

    public function testShouldFailWithoutConnectorId(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface(__DIR__ . '/payloads/ConnectorPutFullPayload.json');

        $this->expectException(OcpiNotEnoughInformationClientError::class);
        new OcpiEmspConnectorPutRequest($serverRequestInterface, new LocationRequestParams('FR', 'TNM', 'LOC1', '3256'));
    }
}
