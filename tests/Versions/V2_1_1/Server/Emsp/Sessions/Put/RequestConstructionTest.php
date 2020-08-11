<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Put;

use Chargemap\OCPI\Common\Server\Errors\OcpiNotEnoughInformationClientError;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Put\OcpiEmspSessionPutRequest;
use DateTime;
use Http\Discovery\Psr17FactoryDiscovery;
use Tests\Chargemap\OCPI\OcpiTestCase;

class RequestConstructionTest extends OcpiTestCase
{
    public function testShouldConstructRequestWithPayload(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface(__DIR__ . '/payloads/SessionPutFullPayload.json');

        $request = new OcpiEmspSessionPutRequest($serverRequestInterface, 'FR', 'TNM', '101');
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
        $serverRequestInterface = $this->createServerRequestInterface(__DIR__ . '/payloads/SessionPutPayloadLocationNotAlwaysOpen.json');

        $request = new OcpiEmspSessionPutRequest($serverRequestInterface, 'FR', 'TNM', '101');
        $session = $request->getSession();
        $location = $session->getLocation();
        $this->assertCount(2, $location->getOpeningTimes()->getRegularHours());
    }

    public function testWithoutBody(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface();
        $serverRequestInterface = $serverRequestInterface->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(""));

        $this->expectException(OcpiNotEnoughInformationClientError::class);
        new OcpiEmspSessionPutRequest($serverRequestInterface, 'FR', 'TNM', '101');
    }
}
