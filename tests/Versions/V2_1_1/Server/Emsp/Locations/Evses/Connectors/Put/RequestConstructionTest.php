<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Connectors\Put;

use Chargemap\OCPI\Common\Server\Errors\OcpiNotEnoughInformationClientError;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Connectors\Put\OcpiEmspConnectorPutRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use DateTime;
use Tests\Chargemap\OCPI\OcpiTestCase;

class RequestConstructionTest extends OcpiTestCase
{
    public function testShouldConstructRequestWithFullPayload(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface(__DIR__ . '/payloads/ConnectorPutFullPayload.json');

        $request = new OcpiEmspConnectorPutRequest($serverRequestInterface, new LocationRequestParams('FR', 'TNM', 'LOC1', '3256', '1'));
        $this->assertEquals('FR', $request->getCountryCode());
        $this->assertEquals('TNM', $request->getPartyId());
        $this->assertEquals('LOC1', $request->getLocationId());
        $this->assertEquals('3256', $request->getEvseUid());
        $this->assertEquals('1', $request->getConnectorId());

        $connector = $request->getConnector();
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

    public function testShouldConstructWithMinPayload(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface(__DIR__ . '/payloads/ConnectorPutMinPayload.json');

        $request = new OcpiEmspConnectorPutRequest($serverRequestInterface, new LocationRequestParams('FR', 'TNM', 'LOC1', '3256', '1'));
        $connector = $request->getConnector();
        $this->assertNull($connector->getTariffId());
        $this->assertNull($connector->getTermsAndConditions());
    }

    public function testShouldFailWithoutConnectorId(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface(__DIR__ . '/payloads/ConnectorPutFullPayload.json');

        $this->expectException(OcpiNotEnoughInformationClientError::class);
        new OcpiEmspConnectorPutRequest($serverRequestInterface, new LocationRequestParams('FR', 'TNM', 'LOC1', '3256'));
    }
}
