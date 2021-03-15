<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Credentials\Put;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\CredentialsFactory;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Credentials\Put\OcpiEmspCredentialsPutResponse;
use PHPUnit\Framework\TestCase;
use Tests\Chargemap\OCPI\OcpiTestCase;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models\CredentialsTest;

class ResponseConstructionTest extends TestCase
{
    public function testShouldConstructCorrectly(): void
    {
        $credentials = CredentialsFactory::fromJson(json_decode(file_get_contents(__DIR__ . '/payloads/CredentialsPayload.json')));
        $response = new OcpiEmspCredentialsPutResponse($credentials, 'Message!');
        $responseInterface = $response->getResponseInterface();
        $this->assertSame(200, $responseInterface->getStatusCode());
        $jsonCredentials = json_decode($responseInterface->getBody()->getContents())->data;
        $schemaPath = __DIR__ . '/../../../../../../../src/Versions/V2_1_1/Server/Emsp/Schemas/credentialsPost.schema.json';
        OcpiTestCase::coerce($schemaPath, $jsonCredentials);
        CredentialsTest::assertJsonSerialize($credentials, $jsonCredentials);
    }
}
