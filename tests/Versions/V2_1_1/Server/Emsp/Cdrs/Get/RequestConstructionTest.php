<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Cdrs\Get;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Cdrs\Get\OcpiEmspCdrGetRequest;
use Tests\Chargemap\OCPI\OcpiTestCase;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Cdrs\Get\OcpiEmspCdrGetRequest
 */
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
