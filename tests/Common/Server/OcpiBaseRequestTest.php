<?php

namespace Tests\Chargemap\OCPI\Common\Server;

use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidTokenClientError;
use Chargemap\OCPI\Common\Server\Errors\OcpiNotEnoughInformationClientError;
use Chargemap\OCPI\Common\Server\OcpiBaseRequest;
use Chargemap\OCPI\Common\Server\OcpiUpdateRequest;
use Http\Discovery\Psr17FactoryDiscovery;
use ReflectionClass;
use Tests\Chargemap\OCPI\OcpiTestCase;

class OcpiBaseRequestTest extends OcpiTestCase
{
    public function invalidTokenProvider(): array
    {
        return [
            'No space' => ['TokenIpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM='],
            'Missing Token keyword' => ['IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM='],
            'Invalid \n character' => ["Token IpbJOXxkxOAuKR92z0n\nEcmVF3Qw09VG7I7d/WCg0koM="],
            'Invalid \n in Token keyword' => ["Token\n IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM="],
        ];
    }

    /**
     * @dataProvider invalidTokenProvider
     */
    public function testShouldFailWithInvalidToken(string $token)
    {
        /** @var OcpiUpdateRequest $mock */
        $mock = $this->getMockBuilder(OcpiBaseRequest::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $reflectedClass = new ReflectionClass(OcpiBaseRequest::class);
        $constructor = $reflectedClass->getConstructor();

        $serverRequestInterface = Psr17FactoryDiscovery::findServerRequestFactory()
            ->createServerRequest('GET', 'randomUrl')
            ->withHeader('Authorization', $token);

        $this->expectException(OcpiInvalidTokenClientError::class);
        $constructor->invoke($mock, $serverRequestInterface);
    }

    public function testShouldThrowNotEnoughParametersExceptionWithoutAuthorizationHeader(): void
    {
        /** @var OcpiUpdateRequest $mock */
        $mock = $this->getMockBuilder(OcpiBaseRequest::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $reflectedClass = new ReflectionClass(OcpiBaseRequest::class);
        $constructor = $reflectedClass->getConstructor();

        $serverRequestInterface = Psr17FactoryDiscovery::findServerRequestFactory()
            ->createServerRequest('GET', 'randomUrl');

        $this->expectException(OcpiNotEnoughInformationClientError::class);
        $constructor->invoke($mock, $serverRequestInterface);
    }

    public function testShouldReturnCorrectToken(): void
    {
        /** @var OcpiUpdateRequest $mock */
        $mock = $this->getMockBuilder(OcpiBaseRequest::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $reflectedClass = new ReflectionClass(OcpiBaseRequest::class);
        $constructor = $reflectedClass->getConstructor();
        $serverRequestInterface = $this->createServerRequestInterface();

        $constructor->invoke($mock, $serverRequestInterface);

        $this->assertSame('IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=', $mock->getAuthorization());
    }
}
