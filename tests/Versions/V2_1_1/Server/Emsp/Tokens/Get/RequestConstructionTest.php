<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Tokens\Get;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Tokens\Get\OcpiEmspTokenGetRequest;
use DateTime;
use Http\Discovery\Psr17FactoryDiscovery;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class RequestConstructionTest extends TestCase
{
    public function testShouldConstructWithoutDates(): void
    {
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('GET', 'randomUrl?offset=0&limit=10')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=');

        $request = new OcpiEmspTokenGetRequest($requestInterface);
        $this->assertNull($request->getDateTo());
        $this->assertNull($request->getDateFrom());
    }

    public function testShouldConstructWithDateFrom(): void
    {
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('GET', 'randomUrl?offset=0&limit=10&date_from=25-05-2020')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=');

        $request = new OcpiEmspTokenGetRequest($requestInterface);
        $this->assertSame((new DateTime('25-05-2020'))->format(DateTime::ISO8601), $request->getDateFrom()->format(DateTime::ISO8601));
        $this->assertNull($request->getDateTo());
    }

    public function testShouldConstructWithDateTo(): void
    {
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('GET', 'randomUrl?offset=0&limit=10&date_to=25-05-2020')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=');

        $request = new OcpiEmspTokenGetRequest($requestInterface);
        $this->assertSame((new DateTime('25-05-2020'))->format(DateTime::ISO8601), $request->getDateTo()->format(DateTime::ISO8601));
        $this->assertNull($request->getDateFrom());
    }

    public function testShouldConstructWithDates(): void
    {
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('GET', 'randomUrl?offset=0&limit=10&date_from=25-05-2020&date_to=26-05-2020')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=');

        $request = new OcpiEmspTokenGetRequest($requestInterface);
        $this->assertSame((new DateTime('25-05-2020'))->format(DateTime::ISO8601), $request->getDateFrom()->format(DateTime::ISO8601));
        $this->assertSame((new DateTime('26-05-2020'))->format(DateTime::ISO8601), $request->getDateTo()->format(DateTime::ISO8601));
    }

    public function testShouldThrowWithInvalidDates(): void
    {
        $requestInterface = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('GET', 'randomUrl?offset=0&limit=10&date_from=26-05-2020&date_to=25-05-2020')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=');

        $this->expectException(InvalidArgumentException::class);
        new OcpiEmspTokenGetRequest($requestInterface);
    }
}
