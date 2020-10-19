<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Patch;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PartialLocation;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Patch\OcpiEmspLocationPatchResponse;
use PHPUnit\Framework\TestCase;

class ResponseConstructionTest extends TestCase
{
    public function testDataShouldBeNull(): void
    {
        $partialLocation = $this->createMock(PartialLocation::class);

        // Create response
        $response = new OcpiEmspLocationPatchResponse($partialLocation);
        $responseInterface = $response->getResponseInterface();
        $data = json_decode($responseInterface->getBody()->getContents())->data;
        $this->assertNull($data);
    }
}
