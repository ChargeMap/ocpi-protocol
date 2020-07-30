<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Connectors\Patch;

use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Connectors\Patch\OcpiEmspConnectorPatchRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use DateTime;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;

class RequestConstructionTest extends TestCase
{
    public function testShouldConstructRequestWithFullPayload(): void
    {
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('PATCH', 'randomUrl')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(
                file_get_contents(__DIR__ . '/payloads/ConnectorPatchFullPayload.json')
            ));

        $request = new OcpiEmspConnectorPatchRequest($requestInterface, new LocationRequestParams('FR', 'TNM', 'LOC1', '3256', '1'));
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
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('PATCH', 'randomUrl')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(
                file_get_contents(__DIR__ . '/payloads/ConnectorPatchLastUpdatedPayload.json')
            ));

        $request = new OcpiEmspConnectorPatchRequest($requestInterface, new LocationRequestParams('FR', 'TNM', 'LOC1', '3256', '1'));
        $partialConnector = $request->getPartialConnector();
        $this->assertNull($partialConnector->getId());
        $this->assertNull($partialConnector->getVoltage());
        $this->assertNull($partialConnector->getPowerType());
        $this->assertEquals(new DateTime('2015-03-16T10:10:02Z'), $partialConnector->getLastUpdated());
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
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('PATCH', 'randomUrl')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($payload));
        $this->expectException(OcpiInvalidPayloadClientError::class);
        new OcpiEmspConnectorPatchRequest($requestInterface, new LocationRequestParams('FR', 'TNM', 'LOC1', '3256', '1'));
    }
}
