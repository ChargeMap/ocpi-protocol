<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Put;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Location;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Put\OcpiEmspLocationPutResponse;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Put\OcpiEmspLocationPutResponse
 */
class ResponseConstructionTest extends TestCase
{
    public function testDataShouldBeNull(): void
    {
        $location = $this->createMock(Location::class);

        // Create response
        $response = new OcpiEmspLocationPutResponse($location);
        $responseInterface = $response->getResponseInterface();
        $data = json_decode($responseInterface->getBody()->getContents())->data;
        $this->assertNull($data);
    }
}
