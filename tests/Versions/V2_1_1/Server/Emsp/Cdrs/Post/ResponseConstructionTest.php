<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Cdrs\Post;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Cdr;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Cdrs\Post\OcpiEmspCdrPostResponse;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Cdrs\Post\OcpiEmspCdrPostResponse
 */
class ResponseConstructionTest extends TestCase
{
    public function testDataShouldBeNullAndHeaderIsProvided(): void
    {
        $cdr = $this->createMock(Cdr::class);
        // Create response
        $response = new OcpiEmspCdrPostResponse($cdr, 'someUrl');
        $responseInterface = $response->getResponseInterface();
        $data = json_decode($responseInterface->getBody()->getContents())->data;
        $this->assertNull($data);
        $this->assertEquals('someUrl', $responseInterface->getHeaderLine('Location'));
    }
}
