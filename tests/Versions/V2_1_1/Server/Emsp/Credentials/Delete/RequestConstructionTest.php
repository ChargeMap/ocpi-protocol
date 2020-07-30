<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Credentials\Delete;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Credentials\Delete\OcpiEmspCredentialsDeleteRequest;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;

class RequestConstructionTest extends TestCase
{
    public function testShouldConstructWithValidRequest(): void
    {
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('GET', 'randomUrl?offset=0&limit=10')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=');
        $request = new OcpiEmspCredentialsDeleteRequest($requestInterface);
        $this->assertInstanceOf(OcpiEmspCredentialsDeleteRequest::class, $request);
    }
}
