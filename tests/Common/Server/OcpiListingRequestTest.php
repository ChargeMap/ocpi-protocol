<?php

namespace Tests\Chargemap\OCPI\Common\Server;

use Chargemap\OCPI\Common\Server\OcpiListingRequest;
use Http\Discovery\Psr17FactoryDiscovery;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class OcpiListingRequestTest extends TestCase
{
    public function invalidParamsProvider(): array
    {
        return [
            [-1, 0],
            [0, -1]
        ];
    }

    /**
     * @dataProvider invalidParamsProvider
     */
    public function testShouldFailWithInvalidHeaders(int $offset, int $limit): void
    {
        /** @var OcpiListingRequest $mock */
        $mock = $this->getMockBuilder(OcpiListingRequest::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $reflectedClass = new ReflectionClass(OcpiListingRequest::class);
        $constructor = $reflectedClass->getConstructor();
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('GET', 'randomUrl?offset=' . $offset . '&limit=' . $limit)
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=');
        $this->expectException(InvalidArgumentException::class);
        $constructor->invoke($mock, $requestInterface);
    }

    public function validParamsProvider(): array
    {
        return [
            [null, null],
            [0, null],
            [null, 0],
            [0, 0],
        ];
    }

    /**
     * @dataProvider validParamsProvider
     */
    public function testShouldSetValidLimitAndOffset(?int $limit, ?int $offset): void
    {
        /** @var OcpiListingRequest $mock */
        $mock = $this->getMockBuilder(OcpiListingRequest::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $reflectedClass = new ReflectionClass(OcpiListingRequest::class);
        $constructor = $reflectedClass->getConstructor();
        $url = 'randomUrl';
        if ($limit !== null || $offset !== null) {
            $url = $url . '?';
            if ($limit !== null) {
                $url = $url . 'limit=' . $limit;
                if ($offset !== null) {
                    $url = $url . '&';
                }
            }
            if ($offset !== null) {
                $url = $url . 'offset=' . $offset;
            }
        }
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('GET', $url)
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=');

        $constructor->invoke($mock, $requestInterface);
        $this->assertEquals($offset, $mock->getOffset());
        $this->assertEquals($limit, $mock->getLimit());
    }
}
