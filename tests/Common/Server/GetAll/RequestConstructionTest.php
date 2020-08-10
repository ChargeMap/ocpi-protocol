<?php

namespace Tests\Chargemap\OCPI\Common\Server\GetAll;

use Chargemap\OCPI\Common\Server\GetAll\OcpiGetAllVersionsRequest;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;
use Tests\Chargemap\OCPI\OcpiTestCase;

class RequestConstructionTest extends OcpiTestCase
{
    public function testShouldConstructWithValidRequest(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface()
            ->withQueryParams([ 'offset' => '10', 'limit' => '10']);

        $request = new OcpiGetAllVersionsRequest($serverRequestInterface);
        $this->assertInstanceOf(OcpiGetAllVersionsRequest::class, $request);
    }
}
