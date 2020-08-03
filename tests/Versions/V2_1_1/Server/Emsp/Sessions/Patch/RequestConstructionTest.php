<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Patch;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Patch\OcpiEmspSessionPatchRequest;
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
                file_get_contents(__DIR__ . '/payloads/SessionPatchFullPayload.json')
            ));

        $request = new OcpiEmspSessionPatchRequest($requestInterface, 'FR', 'TNM', '101');
        $session = $request->getPartialSession();

        $this->assertEquals('101', $session->getId());
        $this->assertEquals(new DateTime('2015-06-29T22:39:09Z'), $session->getStartDate());
        $this->assertEquals('DE8ACC12E46L89', $session->getAuthId());
        $this->assertEquals('AUTH_REQUEST', $session->getAuthMethod()->getValue());
        $this->assertCount(2, $session->getChargingPeriods());
        $location = $session->getLocation();
        $this->assertEquals('LOC1', $location->getId());
        $this->assertEquals('ON_STREET', $location->getLocationType()->getValue());
        $this->assertCount(2, $location->getEvses());
    }

    public function testShouldConstructWithLocation(): void
    {
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('PATCH', 'randomUrl')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(
                file_get_contents(__DIR__ . '/payloads/SessionPatchLocationPayload.json')
            ));

        $request = new OcpiEmspSessionPatchRequest($requestInterface, 'FR', 'TNM', '101');
        $session = $request->getPartialSession();
        $this->assertNull($session->getId());
        $this->assertNotNull($session->getLocation());
    }

    public function testShouldConstructWithChargingPeriodsPayload(): void
    {
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('PATCH', 'randomUrl')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(
                file_get_contents(__DIR__ . '/payloads/SessionPatchChargingPeriodsPayload.json')
            ));

        $request = new OcpiEmspSessionPatchRequest($requestInterface, 'FR', 'TNM', '101');
        $session = $request->getPartialSession();
        $this->assertNull($session->getId());
        $this->assertNull($session->getId());
        $this->assertNotEmpty($session->getChargingPeriods());
        $this->assertCount(2, $session->getChargingPeriods());
    }
}
