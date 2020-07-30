<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Cdrs\Get;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Cdrs\Get\OcpiEmspCdrGetRequest;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;

class RequestConstructionTest extends TestCase
{
    public function testShouldConstructWithValidRequest(): void
    {
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('GET', 'randomUrl')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=');
        $request = new OcpiEmspCdrGetRequest($requestInterface, '1234');
        $this->assertInstanceOf(OcpiEmspCdrGetRequest::class, $request);
        $this->assertEquals('1234', $request->getCdrId());
    }
}
