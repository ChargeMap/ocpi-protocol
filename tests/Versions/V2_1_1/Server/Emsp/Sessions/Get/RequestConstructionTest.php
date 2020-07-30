<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Get;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Get\OcpiEmspSessionGetRequest;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;

class RequestConstructionTest extends TestCase
{
    public function testShouldConstructValidRequest(): void
    {
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('GET', 'randomUrl')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=');
        $request = new OcpiEmspSessionGetRequest($requestInterface, 'EN', 'PID', 'sessionId');
        $this->assertInstanceOf(OcpiEmspSessionGetRequest::class, $request);
        $this->assertEquals('EN', $request->getCountryCode());
        $this->assertEquals('PID', $request->getPartyId());
        $this->assertEquals('sessionId', $request->getSessionId());
    }
}
