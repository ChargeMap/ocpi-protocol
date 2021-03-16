<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Tokens\Post;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\DisplayTextFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\LocationReferencesFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\AllowedType;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\DisplayText;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\LocationReferences;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Tokens\Post\OcpiEmspTokenPostResponse;
use PHPUnit\Framework\TestCase;
use Tests\Chargemap\OCPI\InvalidPayloadException;
use Tests\Chargemap\OCPI\OcpiTestCase;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models\DisplayTextTest;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models\LocationReferencesTest;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Tokens\Post\OcpiEmspTokenPostResponse
 */
class ResponseConstructionTest extends TestCase
{
    public function validParametersProvider(): iterable
    {
        foreach (scandir(__DIR__ . '/payloads/responses/') as $filename) {
            if (!is_dir(__DIR__ . '/payloads/responses/' . $filename)) {
                $payload = json_decode(file_get_contents(__DIR__ . '/payloads/responses/' . $filename));
                yield basename($filename, '.json') => [
                    'allowed' => new AllowedType($payload->allowed),
                    'location' => LocationReferencesFactory::fromJson($payload->location),
                    'info' => DisplayTextFactory::fromJson($payload->info),
                ];
            }
        }
    }

    /**
     * @dataProvider validParametersProvider
     * @param AllowedType $allowedType
     * @param LocationReferences|null $locationReferences
     * @param DisplayText|null $info
     * @throws InvalidPayloadException
     */
    public function testDataIsCorrect(
        AllowedType $allowedType,
        ?LocationReferences $locationReferences,
        ?DisplayText $info
    ): void {
        $response = new OcpiEmspTokenPostResponse($allowedType, $locationReferences, $info);
        $responseInterface = $response->getResponseInterface();

        $jsonPayload = json_decode($responseInterface->getBody()->getContents())->data;
        $schemaPath = __DIR__ . '/../../../../../../../src/Versions/V2_1_1/Server/Emsp/Schemas/authorizationTokenPostResponse.schema.json';
        OcpiTestCase::coerce($schemaPath, $jsonPayload);

        $this->assertSame($response->getAllowedType()->getValue(), $jsonPayload->allowed);
        LocationReferencesTest::assertJsonSerialization($response->getLocationReferences(), $jsonPayload->location);
        DisplayTextTest::assertDisplayText($response->getInfo(), $jsonPayload->info);
    }
}
