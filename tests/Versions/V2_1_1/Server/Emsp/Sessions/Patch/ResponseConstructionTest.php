<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Patch;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Patch\OcpiEmspSessionPatchResponse;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PartialSession;
use PHPUnit\Framework\TestCase;

class ResponseConstructionTest extends TestCase
{
    public function testDataShouldBeNull(): void
    {
        $session = $this->createMock(PartialSession::class);

        // Create response
        $response = new OcpiEmspSessionPatchResponse($session);
        $responseInterface = $response->getResponseInterface();
        $data = json_decode($responseInterface->getBody()->getContents())->data;
        $this->assertNull($data);
    }
}
