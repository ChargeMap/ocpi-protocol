<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Put;

use Chargemap\OCPI\Common\Server\Errors\OcpiNotEnoughInformationClientError;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Put\OcpiEmspSessionPutRequest;
use DateTime;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;

class RequestConstructionTest extends TestCase
{
    public function testShouldConstructRequestWithPayload(): void
    {
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('PUT', 'randomUrl')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(
                file_get_contents(__DIR__ . '/payloads/SessionPutFullPayload.json')
            ));

        $request = new OcpiEmspSessionPutRequest($requestInterface, 'FR', 'TNM', '101');
        $this->assertEquals('FR', $request->getCountryCode());
        $this->assertEquals('TNM', $request->getPartyId());
        $this->assertEquals('101', $request->getSessionId());

        $session = $request->getSession();
        $this->assertEquals('101', $session->getId());
        $this->assertEquals(new DateTime('2015-06-29T22:39:09Z'), $session->getStartDate());
        $this->assertEquals('DE8ACC12E46L89', $session->getAuthId());
        $this->assertEquals('AUTH_REQUEST', $session->getAuthMethod()->getValue());
        $location = $session->getLocation();
        $this->assertEquals('LOC1', $location->getId());
        $this->assertEquals('ON_STREET', $location->getLocationType()->getValue());
        $this->assertCount(2, $location->getEvses());
    }

    public function testShouldConstructWithUnusualLocation(): void
    {
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('PUT', 'randomUrl')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(
                file_get_contents(__DIR__ . '/payloads/SessionPutPayloadLocationNotAlwaysOpen.json')
            ));

        $request = new OcpiEmspSessionPutRequest($requestInterface, 'FR', 'TNM', '101');
        $session = $request->getSession();
        $location = $session->getLocation();
        $this->assertCount(2, $location->getOpeningTimes()->getRegularHours());
    }

    public function testWithoutBody(): void
    {
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('PUT', 'randomUrl')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(""));
        $this->expectException(OcpiNotEnoughInformationClientError::class);
        new OcpiEmspSessionPutRequest($requestInterface, 'FR', 'TNM', '101');
    }
}
