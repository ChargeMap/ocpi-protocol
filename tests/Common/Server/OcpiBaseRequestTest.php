<?php

namespace Tests\Chargemap\OCPI\Common\Server;

use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidTokenClientError;
use Chargemap\OCPI\Common\Server\Errors\OcpiNotEnoughInformationClientError;
use Chargemap\OCPI\Common\Server\OcpiBaseRequest;
use Chargemap\OCPI\Common\Server\OcpiUpdateRequest;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class OcpiBaseRequestTest extends TestCase
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
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('GET', 'randomUrl')
            ->withHeader('Authorization', $token);

        $this->expectException(OcpiInvalidTokenClientError::class);
        $constructor->invoke($mock, $requestInterface);
    }

    public function testShouldThrowNotEnoughParametersExceptionWithoutAuthorizationHeader(): void
    {
        /** @var OcpiUpdateRequest $mock */
        $mock = $this->getMockBuilder(OcpiBaseRequest::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $reflectedClass = new ReflectionClass(OcpiBaseRequest::class);
        $constructor = $reflectedClass->getConstructor();
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('GET', 'randomUrl');

        $this->expectException(OcpiNotEnoughInformationClientError::class);
        $constructor->invoke($mock, $requestInterface);
    }

    public function testShouldReturnCorrectToken(): void
    {
        /** @var OcpiUpdateRequest $mock */
        $mock = $this->getMockBuilder(OcpiBaseRequest::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $reflectedClass = new ReflectionClass(OcpiBaseRequest::class);
        $constructor = $reflectedClass->getConstructor();
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('GET', 'randomUrl')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=');

        $constructor->invoke($mock, $requestInterface);

        $this->assertSame('IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=', $mock->getAuthorization());
    }
}
