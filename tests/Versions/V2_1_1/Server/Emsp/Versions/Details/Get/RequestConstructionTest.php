<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Versions\Details\Get;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Versions\Details\Get\OcpiEmspVersionDetailsGetRequest;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;

class RequestConstructionTest extends TestCase
{
    public function testShouldConstructWithValidRequest(): void
    {
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('GET', 'randomUrl?offset=0&limit=10')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=');
        $request = new OcpiEmspVersionDetailsGetRequest($requestInterface);
        $this->assertInstanceOf(OcpiEmspVersionDetailsGetRequest::class, $request);
    }
}
