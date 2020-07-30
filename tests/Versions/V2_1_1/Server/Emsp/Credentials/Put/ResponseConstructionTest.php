<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Credentials\Put;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Credentials\Put\OcpiEmspCredentialsPutResponse;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\CredentialsFactory;
use PHPUnit\Framework\TestCase;

class ResponseConstructionTest extends TestCase
{
    public function testShouldConstructCorrectly(): void
    {
        $credentials = CredentialsFactory::fromJson(json_decode(file_get_contents(__DIR__ . '/payloads/CredentialsPayload.json')));
        $response = new OcpiEmspCredentialsPutResponse($credentials, 'Message!');
        $responseInterface = $response->getResponseInterface();
        $this->assertSame(200, $responseInterface->getStatusCode());
        $serialized = json_decode($responseInterface->getBody()->getContents(), true)['data'];
        $this->assertSame('https://example.com/ocpi/cpo/versions/', $serialized['url']);
        $this->assertSame('ebf3b399-779f-4497-9b9d-ac6ad3cc44d2', $serialized['token']);
        $this->assertSame('EXA', $serialized['party_id']);
        $this->assertSame('NL', $serialized['country_code']);

        $businessDetails = $serialized['business_details'];
        $this->assertSame('Example Operator', $businessDetails['name']);
        $this->assertSame('http://example.com', $businessDetails['website']);

        $logo = $businessDetails['logo'];
        $this->assertSame('https://example.com/img/logo.jpg', $logo['url']);
        $this->assertSame('https://example.com/img/logo_thumb.jpg', $logo['thumbnail']);
        $this->assertSame('OPERATOR', $logo['category']);
        $this->assertSame('jpeg', $logo['type']);
        $this->assertSame(512, $logo['width']);
        $this->assertSame(512, $logo['height']);
    }
}
