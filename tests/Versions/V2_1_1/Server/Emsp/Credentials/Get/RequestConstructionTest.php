<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Credentials\Get;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Credentials\Get\OcpiEmspCredentialsGetRequest;
use Tests\Chargemap\OCPI\OcpiTestCase;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Credentials\Get\OcpiEmspCredentialsGetRequest
 */
class RequestConstructionTest extends OcpiTestCase
{
    public function testShouldConstructWithValidRequest(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface()
            ->withQueryParams(['offset' => '0', 'limit' => '10']);

        $request = new OcpiEmspCredentialsGetRequest($serverRequestInterface);
        $this->assertInstanceOf(OcpiEmspCredentialsGetRequest::class, $request);
    }
}
