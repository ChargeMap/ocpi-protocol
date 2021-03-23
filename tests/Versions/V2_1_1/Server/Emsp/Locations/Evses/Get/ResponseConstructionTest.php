<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Get;

use Chargemap\OCPI\Common\Server\StatusCodes\OcpiSuccessHttpCode;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\EVSEFactory;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Get\OcpiEmspEvseGetResponse;
use PHPUnit\Framework\TestCase;
use Tests\Chargemap\OCPI\InvalidPayloadException;
use Tests\Chargemap\OCPI\OcpiTestCase;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models\EvseTest;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Get\OcpiEmspEvseGetResponse
 */
class ResponseConstructionTest extends TestCase
{
    public function validPayloadsProvider(): iterable
    {
        foreach (scandir(__DIR__ . '/payloads/valid/') as $filename) {
            if (!is_dir(__DIR__ . '/payloads/valid/' . $filename)) {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/payloads/valid/' . $filename),
                ];
            }
        }
    }

    /**
     * @dataProvider validPayloadsProvider
     * @param string $payload
     * @throws InvalidPayloadException
     */
    public function testShouldSerializeLocationCorrectlyWithFullPayload(string $payload)
    {
        $evse = EVSEFactory::fromJson(json_decode($payload));
        $response = new OcpiEmspEvseGetResponse($evse);

        $responseInterface = $response->getResponseInterface();
        $this->assertSame(OcpiSuccessHttpCode::HTTP_OK, $responseInterface->getStatusCode());
        $json = json_decode($responseInterface->getBody()->getContents());
        OcpiTestCase::coerce('V2_1_1/eMSP/Server/Locations/Evses/evseGetResponse.schema.json', $json);
        EvseTest::assertJsonSerialization($evse, $json->data);
    }
}
