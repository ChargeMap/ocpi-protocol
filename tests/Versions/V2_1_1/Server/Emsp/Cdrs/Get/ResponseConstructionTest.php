<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Cdrs\Get;

use Chargemap\OCPI\Common\Server\StatusCodes\OcpiSuccessHttpCode;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\CdrFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Cdr;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Cdrs\Get\OcpiEmspCdrGetResponse;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;
use Tests\Chargemap\OCPI\InvalidPayloadException;
use Tests\Chargemap\OCPI\OcpiTestCase;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories\CdrFactoryTest;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Cdrs\Get\OcpiEmspCdrGetResponse
 */
class ResponseConstructionTest extends TestCase
{
    public function validPayloadsProvider(): iterable
    {
        foreach (scandir(__DIR__ . '/payloads/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield basename($filename, '.json') => [__DIR__ . '/payloads/' . $filename];
            }
        }
    }

    /**
     * @dataProvider validPayloadsProvider
     * @param string $filename
     * @throws InvalidPayloadException
     */
    public function testShouldSerializeCdrCorrectlyWithPayload(string $filename)
    {
        $cdr = CdrFactory::fromJson(json_decode(file_get_contents($filename)));

        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $response = new OcpiEmspCdrGetResponse($cdr);

        $responseInterface = $response->getResponseInterface($responseFactory, $streamFactory);
        $this->assertSame(OcpiSuccessHttpCode::HTTP_OK, $responseInterface->getStatusCode());

        $jsonCdr = json_decode($responseInterface->getBody()->getContents())->data;
        $schemaPath = __DIR__ . '/../../../../../../../src/Versions/V2_1_1/Server/Emsp/Schemas/cdrPost.schema.json';
        OcpiTestCase::coerce($schemaPath, $jsonCdr);
        //TODO: use CdrTest::assertJsonSerialization($cdr, $jsonCdr) instead
        CdrFactoryTest::assertCdr($jsonCdr, $cdr);
    }

    public function testShouldAddMessage(): void
    {
        $cdr = $this->createMock(Cdr::class);
        $response = new OcpiEmspCdrGetResponse($cdr, 'Cdr is here');

        $responseInterface = $response->getResponseInterface();

        $this->assertEquals(
            'Cdr is here',
            json_decode($responseInterface->getBody()->getContents())->status_message
        );
    }
}
