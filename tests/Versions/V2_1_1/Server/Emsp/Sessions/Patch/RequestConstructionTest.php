<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Patch;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Patch\OcpiEmspSessionPatchRequest;
use DateTime;
use Tests\Chargemap\OCPI\OcpiTestCase;

class RequestConstructionTest extends OcpiTestCase
{
    public function testShouldConstructRequestWithFullPayload(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface(__DIR__ . '/payloads/SessionPatchFullPayload.json');

        $request = new OcpiEmspSessionPatchRequest($serverRequestInterface, 'FR', 'TNM', '101');
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
        $serverRequestInterface = $this->createServerRequestInterface(__DIR__ . '/payloads/SessionPatchLocationPayload.json');

        $request = new OcpiEmspSessionPatchRequest($serverRequestInterface, 'FR', 'TNM', '101');
        $session = $request->getPartialSession();
        $this->assertSame('101',$session->getId());
        $this->assertNotNull($session->getLocation());
    }

    public function testShouldConstructWithChargingPeriodsPayload(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface(__DIR__ . '/payloads/SessionPatchChargingPeriodsPayload.json');

        $request = new OcpiEmspSessionPatchRequest($serverRequestInterface, 'FR', 'TNM', '101');
        $session = $request->getPartialSession();
        $this->assertSame('101',$session->getId());
        $this->assertNotEmpty($session->getChargingPeriods());
        $this->assertCount(2, $session->getChargingPeriods());
    }
}
