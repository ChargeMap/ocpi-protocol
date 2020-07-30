<?php

namespace Tests\Chargemap\OCPI\Common\Server\GetAll;

use Chargemap\OCPI\Common\Server\GetAll\OcpiGetAllVersionsRequest;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;

class RequestConstructionTest extends TestCase
{
    public function testShouldConstructWithValidRequest(): void
    {
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('GET', 'randomUrl?offset=0&limit=10')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=');
        $request = new OcpiGetAllVersionsRequest($requestInterface);
        $this->assertInstanceOf(OcpiGetAllVersionsRequest::class, $request);
    }
}
