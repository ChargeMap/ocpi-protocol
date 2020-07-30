<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Patch;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Patch\OcpiEmspEvsePatchResponse;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PartialEVSE;
use PHPUnit\Framework\TestCase;

class ResponseConstructionTest extends TestCase
{
    public function testDataShouldBeNull(): void
    {
        $partialEvse = $this->createMock(PartialEVSE::class);

        // Create response
        $response = new OcpiEmspEvsePatchResponse($partialEvse);
        $responseInterface = $response->getResponseInterface();
        $data = json_decode($responseInterface->getBody()->getContents())->data;
        $this->assertNull($data);
    }
}
