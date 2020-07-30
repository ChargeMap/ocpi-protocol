<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Connectors\Put;

use Chargemap\OCPI\Common\Server\Errors\OcpiNotEnoughInformationClientError;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Connectors\Put\OcpiEmspConnectorPutRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use DateTime;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;

class RequestConstructionTest extends TestCase
{
    public function testShouldConstructRequestWithFullPayload(): void
    {
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('PUT', 'randomUrl')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(
                file_get_contents(__DIR__ . '/payloads/ConnectorPutFullPayload.json')
            ));

        $request = new OcpiEmspConnectorPutRequest($requestInterface, new LocationRequestParams('FR', 'TNM', 'LOC1', '3256', '1'));
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
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('PUT', 'randomUrl')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(
                file_get_contents(__DIR__ . '/payloads/ConnectorPutMinPayload.json')
            ));

        $request = new OcpiEmspConnectorPutRequest($requestInterface, new LocationRequestParams('FR', 'TNM', 'LOC1', '3256', '1'));
        $connector = $request->getConnector();
        $this->assertNull($connector->getTariffId());
        $this->assertNull($connector->getTermsAndConditions());
    }

    public function testShouldFailWithoutConnectorId(): void
    {
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('PUT', 'randomUrl')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(
                file_get_contents(__DIR__ . '/payloads/ConnectorPutFullPayload.json')
            ));

        $this->expectException(OcpiNotEnoughInformationClientError::class);
        new OcpiEmspConnectorPutRequest($requestInterface, new LocationRequestParams('FR', 'TNM', 'LOC1', '3256'));
    }
}
