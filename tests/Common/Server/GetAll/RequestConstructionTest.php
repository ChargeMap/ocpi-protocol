<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Common\Server\GetAll;

use Chargemap\OCPI\Common\Server\GetAll\OcpiGetAllVersionsRequest;
use Tests\Chargemap\OCPI\OcpiTestCase;

class RequestConstructionTest extends OcpiTestCase
{
    public function testShouldConstructWithValidRequest(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface()
            ->withQueryParams(['offset' => '10', 'limit' => '10']);

        $request = new OcpiGetAllVersionsRequest($serverRequestInterface);
        $this->assertInstanceOf(OcpiGetAllVersionsRequest::class, $request);
    }
}
