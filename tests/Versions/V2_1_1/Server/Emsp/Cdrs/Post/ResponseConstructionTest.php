<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Cdrs\Post;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Cdr;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Cdrs\Post\OcpiEmspCdrPostResponse;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;

class ResponseConstructionTest extends TestCase
{
    public function testDataShouldBeNullAndHeaderIsProvided(): void
    {
        $cdr = $this->createMock(Cdr::class);

        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        // Create response
        $response = new OcpiEmspCdrPostResponse($cdr, 'someUrl');
        $responseInterface = $response->getResponseInterface($responseFactory, $streamFactory);
        $data = json_decode($responseInterface->getBody()->getContents())->data;
        $this->assertNull($data);
        $this->assertEquals('someUrl', $responseInterface->getHeader('Location')[0]);
    }
}
