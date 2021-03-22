<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Get;

use Chargemap\OCPI\Common\Server\StatusCodes\OcpiSuccessHttpCode;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\SessionFactory;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Get\OcpiEmspSessionGetResponse;
use PHPUnit\Framework\TestCase;
use Tests\Chargemap\OCPI\InvalidPayloadException;
use Tests\Chargemap\OCPI\OcpiTestCase;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models\SessionTest;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Get\OcpiEmspSessionGetResponse
 */
class ResponseConstructionTest extends TestCase
{
    public function validPayloadsProvider(): iterable
    {
        foreach (scandir(__DIR__ . '/payloads/valid/') as $filename) {
            if (!is_dir(__DIR__ . '/payloads/valid/' . $filename)) {
                yield basename($filename, '.json') => [file_get_contents(__DIR__ . '/payloads/valid/' . $filename)];
            }
        }
    }

    /**
     * @dataProvider validPayloadsProvider
     * @param string $payload
     * @throws InvalidPayloadException
     */
    public function testShouldSerializeSessionCorrectlyWithFullPayload(string $payload): void
    {
        $session = SessionFactory::fromJson(json_decode($payload));
        $response = new OcpiEmspSessionGetResponse($session);
        $responseInterface = $response->getResponseInterface();
        $this->assertSame(OcpiSuccessHttpCode::HTTP_OK, $responseInterface->getStatusCode());

        $json = json_decode($responseInterface->getBody()->getContents());
        OcpiTestCase::coerce('eMSP/Server/Sessions/sessionGetResponse.schema.json', $json);
        SessionTest::assertJsonSerialization($session, $json->data);
    }
}
