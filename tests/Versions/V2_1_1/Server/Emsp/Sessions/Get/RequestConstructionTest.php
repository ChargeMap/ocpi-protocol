<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Get;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Get\OcpiEmspSessionGetRequest;
use Tests\Chargemap\OCPI\OcpiTestCase;

class RequestConstructionTest extends OcpiTestCase
{
    public function testShouldConstructValidRequest(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface();

        $request = new OcpiEmspSessionGetRequest($serverRequestInterface, 'EN', 'PID', 'sessionId');
        $this->assertInstanceOf(OcpiEmspSessionGetRequest::class, $request);
        $this->assertEquals('EN', $request->getCountryCode());
        $this->assertEquals('PID', $request->getPartyId());
        $this->assertEquals('sessionId', $request->getSessionId());
    }
}
