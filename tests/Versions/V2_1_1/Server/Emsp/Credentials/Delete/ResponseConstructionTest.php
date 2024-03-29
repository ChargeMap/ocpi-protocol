<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Credentials\Delete;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Credentials\Delete\OcpiEmspCredentialsDeleteResponse;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Credentials\Delete\OcpiEmspCredentialsDeleteResponse
 */
class ResponseConstructionTest extends TestCase
{
    public function testDataShouldBeNull(): void
    {
        $response = new OcpiEmspCredentialsDeleteResponse('Message!');
        $responseInterface = $response->getResponseInterface();
        $data = json_decode($responseInterface->getBody()->getContents())->data;
        $this->assertNull($data);
    }
}
