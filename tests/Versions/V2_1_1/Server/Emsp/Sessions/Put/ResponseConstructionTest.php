<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Put;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Put\OcpiEmspSessionPutResponse;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Session;
use PHPUnit\Framework\TestCase;

class ResponseConstructionTest extends TestCase
{
    public function testDataShouldBeNull(): void
    {
        $session = $this->createMock(Session::class);

        // Create response
        $response = new OcpiEmspSessionPutResponse($session);
        $responseInterface = $response->getResponseInterface();
        $data = json_decode($responseInterface->getBody()->getContents())->data;
        $this->assertNull($data);
    }
}
