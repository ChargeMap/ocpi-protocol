<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Credentials\Put;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Credentials\Put\OcpiEmspCredentialsPutRequest;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;

class RequestConstructionTest extends TestCase
{
    public function testShouldConstructWithPayload(): void
    {
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('POST', 'randomUrl')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(
                file_get_contents(__DIR__ . '/payloads/CredentialsPayload.json')
            ));

        $request = new OcpiEmspCredentialsPutRequest($requestInterface);

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
