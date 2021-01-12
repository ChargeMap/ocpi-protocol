<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Connectors\Patch;

use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Connectors\Patch\OcpiEmspConnectorPatchRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Patch\UnsupportedPatchException;
use DateTime;
use Http\Discovery\Psr17FactoryDiscovery;
use Tests\Chargemap\OCPI\OcpiTestCase;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Connectors\Patch\OcpiEmspConnectorPatchRequest
 */
class RequestConstructionTest extends OcpiTestCase
{
    public function testShouldConstructRequestWithFullPayload(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface(__DIR__ . '/payloads/ConnectorPatchFullPayload.json');

        $request = new OcpiEmspConnectorPatchRequest($serverRequestInterface, new LocationRequestParams('FR', 'TNM', 'LOC1', '3256', '1'));
        $this->assertEquals('FR', $request->getCountryCode());
        $this->assertEquals('TNM', $request->getPartyId());
        $this->assertEquals('LOC1', $request->getLocationId());
        $this->assertEquals('3256', $request->getEvseUid());
        $this->assertEquals('1', $request->getConnectorId());

        $connector = $request->getPartialConnector();
        $this->assertEquals('1', $connector->getId());
        $this->assertEquals('IEC_62196_T2', $connector->getStandard()->getValue());
        $this->assertEquals('CABLE', $connector->getFormat());
        $this->assertEquals('AC_3_PHASE', $connector->getPowerType()->getValue());
        $this->assertEquals(220, $connector->getVoltage());
        $this->assertEquals(16, $connector->getAmperage());
        $this->assertEquals('11', $connector->getTariffId());
        $this->assertEquals('https://google.com', $connector->getTermsAndConditions());
        $this->assertEquals(new DateTime('2015-03-16T10:10:02Z'), $connector->getLastUpdated());
    }

    public function testShouldConstructWithLastUpdated()
    {
        $serverRequestInterface = $this->createServerRequestInterface(__DIR__ . '/payloads/ConnectorPatchLastUpdatedPayload.json');

        $request = new OcpiEmspConnectorPatchRequest($serverRequestInterface, new LocationRequestParams('FR', 'TNM', 'LOC1', '3256', '1'));
        $partialConnector = $request->getPartialConnector();
        $this->assertNull($partialConnector->getId());
        $this->assertNull($partialConnector->getVoltage());
        $this->assertNull($partialConnector->getPowerType());
        $this->assertEquals(new DateTime('2015-03-16T10:10:02Z'), $partialConnector->getLastUpdated());
    }

    public function testShouldConstructWithNullTermsAndConditions()
    {
        $serverRequestInterface = $this->createServerRequestInterface(__DIR__ . '/payloads/ConnectorPatchNullPayload.json');

        $request = new OcpiEmspConnectorPatchRequest($serverRequestInterface, new LocationRequestParams('FR', 'TNM', 'LOC1', '3256', '1'));
        $partialConnector = $request->getPartialConnector();
        $this->assertNull($partialConnector->getId());
        $this->assertNull($partialConnector->getVoltage());
        $this->assertNull($partialConnector->getPowerType());
        $this->assertEquals(null, $partialConnector->getTermsAndConditions());
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
        $serverRequestInterface = $this->createServerRequestInterface(__DIR__ . '/payloads/ConnectorPatchFullPayload.json');

        $this->expectException(UnsupportedPatchException::class);
        new OcpiEmspConnectorPatchRequest($serverRequestInterface, new LocationRequestParams('FR', 'TNM', 'LOC1', '3256', '2'));
    }
}
