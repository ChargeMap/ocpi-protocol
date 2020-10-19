<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Versions\Details\Get;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Versions\Details\Get\OcpiEmspVersionDetailsGetRequest;
use Tests\Chargemap\OCPI\OcpiTestCase;

class RequestConstructionTest extends OcpiTestCase
{
    public function testShouldConstructWithValidRequest(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface()
            ->withQueryParams(['offset' => '0', 'limit' => '10']);

        $request = new OcpiEmspVersionDetailsGetRequest($serverRequestInterface);
        $this->assertInstanceOf(OcpiEmspVersionDetailsGetRequest::class, $request);
    }
}
