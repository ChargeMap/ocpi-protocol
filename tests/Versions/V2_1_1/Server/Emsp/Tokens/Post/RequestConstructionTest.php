<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Tokens\Post;

use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Tokens\Post\OcpiEmspTokenPostRequest;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\TokenType;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;

class RequestConstructionTest extends TestCase
{
    public function testShouldConstructRequestWithPayload(): void
    {
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('GET', 'randomUrl?type=rfid')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(
                file_get_contents(__DIR__ . '/payloads/TokenPostPayload.json')
            ));

        $request = new OcpiEmspTokenPostRequest($requestInterface, '4050933D');
        $this->assertEquals('4050933D', $request->getTokenId());
        $this->assertEquals(TokenType::RFID, $request->getTokenType()->getValue());
    }

    public function testShouldConstructRequestWithOtherAuthenticationType(): void
    {
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('GET', 'randomUrl?type=other')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(
                file_get_contents(__DIR__ . '/payloads/TokenPostPayload.json')
            ));

        $request = new OcpiEmspTokenPostRequest($requestInterface, '12345');
        $this->assertEquals('12345', $request->getTokenId());
        $this->assertEquals(TokenType::OTHER, $request->getTokenType()->getValue());
    }

    public function testShouldConstructRequestWithoutAuthenticationType(): void
    {
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('GET', 'randomUrl')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(
                file_get_contents(__DIR__ . '/payloads/TokenPostPayload.json')
            ));

        $request = new OcpiEmspTokenPostRequest($requestInterface, '12345');
        $this->assertEquals('12345', $request->getTokenId());
        $this->assertEquals(TokenType::RFID, $request->getTokenType()->getValue());
    }

    public function testShouldFailWithInvalidArgument(): void
    {
        $this->expectException(OcpiInvalidPayloadClientError::class);

        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('GET', 'randomUrl?type=rfid')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(
                file_get_contents(__DIR__ . '/payloads/ErrorInPayload.json')
            ));

        new OcpiEmspTokenPostRequest($requestInterface, '4050933D');
    }
}
