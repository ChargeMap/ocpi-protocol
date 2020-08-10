<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Cdrs\Get;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Cdrs\Get\OcpiEmspCdrGetRequest;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;
use Tests\Chargemap\OCPI\OcpiTestCase;

class RequestConstructionTest extends OcpiTestCase
{
    public function testShouldConstructWithValidRequest(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface();

        $request = new OcpiEmspCdrGetRequest($serverRequestInterface, '1234');
        $this->assertInstanceOf(OcpiEmspCdrGetRequest::class, $request);
        $this->assertEquals('1234', $request->getCdrId());
    }
}
