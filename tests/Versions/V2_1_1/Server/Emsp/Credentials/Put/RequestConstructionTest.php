<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Credentials\Put;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Credentials\Put\OcpiEmspCredentialsPutRequest;
use Tests\Chargemap\OCPI\OcpiTestCase;

class RequestConstructionTest extends OcpiTestCase
{
    public function testShouldConstructWithPayload(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface(__DIR__ . '/payloads/CredentialsPayload.json');

        $request = new OcpiEmspCredentialsPutRequest($serverRequestInterface);

        $credentials = $request->getCredentials();
        $this->assertSame('https://example.com/ocpi/cpo/versions/', $credentials->getUrl());
        $this->assertSame('ebf3b399-779f-4497-9b9d-ac6ad3cc44d2', $credentials->getToken());
        $this->assertSame('EXA', $credentials->getPartyId());
        $this->assertSame('NL', $credentials->getCountryCode());

        $businessDetails = $credentials->getBusinessDetails();
        $this->assertSame('Example Operator', $businessDetails->getName());
        $this->assertSame('http://example.com', $businessDetails->getWebsite());

        $logo = $businessDetails->getLogo();
        $this->assertSame('https://example.com/img/logo.jpg', $logo->getUrl());
        $this->assertSame('https://example.com/img/logo_thumb.jpg', $logo->getThumbnail());
        $this->assertSame('OPERATOR', $logo->getCategory()->getValue());
        $this->assertSame('jpeg', $logo->getType());
        $this->assertSame(512, $logo->getWidth());
        $this->assertSame(512, $logo->getHeight());
    }
}
