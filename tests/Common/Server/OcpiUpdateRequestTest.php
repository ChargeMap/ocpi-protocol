<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Common\Server;

use Chargemap\OCPI\Common\Server\Errors\OcpiNotEnoughInformationClientError;
use Chargemap\OCPI\Common\Server\OcpiUpdateRequest;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use stdClass;

class OcpiUpdateRequestTest extends TestCase
{
    public function testShouldFailWithoutBody(): void
    {
        /** @var OcpiUpdateRequest $mock */
        $mock = $this->getMockBuilder(OcpiUpdateRequest::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $reflectedClass = new ReflectionClass(OcpiUpdateRequest::class);
        $constructor = $reflectedClass->getConstructor();
        $constructor->setAccessible(true);
        $serverRequestInterface = Psr17FactoryDiscovery::findServerRequestFactory()
            ->createServerRequest('GET', 'randomUrl')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=');
        $this->expectException(OcpiNotEnoughInformationClientError::class);
        $constructor->invoke($mock, $serverRequestInterface);
    }

    public function testShouldFailWithEmptyBody(): void
    {
        /** @var OcpiUpdateRequest $mock */
        $mock = $this->getMockBuilder(OcpiUpdateRequest::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $reflectedClass = new ReflectionClass(OcpiUpdateRequest::class);
        $constructor = $reflectedClass->getConstructor();
        $constructor->setAccessible(true);
        $serverRequestInterface = Psr17FactoryDiscovery::findServerRequestFactory()
            ->createServerRequest('GET', 'randomUrl')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(""));
        $this->expectException(OcpiNotEnoughInformationClientError::class);
        $constructor->invoke($mock, $serverRequestInterface);
    }

    public function testShouldSetJsonBody(): void
    {
        /** @var OcpiUpdateRequest $mock */
        $mock = $this->getMockBuilder(OcpiUpdateRequest::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $reflectedClass = new ReflectionClass(OcpiUpdateRequest::class);
        $constructor = $reflectedClass->getConstructor();
        $constructor->setAccessible(true);
        $serverRequestInterface = Psr17FactoryDiscovery::findServerRequestFactory()
            ->createServerRequest('GET', 'randomUrl')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream('{}'));

        $constructor->invoke($mock, $serverRequestInterface);
        $this->assertEquals(new stdClass(), $mock->getJsonBody());
    }

}
