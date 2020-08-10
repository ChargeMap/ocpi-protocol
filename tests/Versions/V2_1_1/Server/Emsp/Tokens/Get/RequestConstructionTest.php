<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Tokens\Get;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Tokens\Get\OcpiEmspTokenGetRequest;
use DateTime;
use Http\Discovery\Psr17FactoryDiscovery;
use InvalidArgumentException;
use Tests\Chargemap\OCPI\OcpiTestCase;

class RequestConstructionTest extends OcpiTestCase
{
    public function testShouldConstructWithoutDates(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface()
            ->withQueryParams([ 'offset' => 0, 'limit' => '10']);

        $request = new OcpiEmspTokenGetRequest($serverRequestInterface);
        $this->assertNull($request->getDateTo());
        $this->assertNull($request->getDateFrom());
    }

    public function testShouldConstructWithDateFrom(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface()
            ->withQueryParams([ 'offset' => '0', 'limit' => '10', 'date_from' => '2020-05-25' ]);

        $request = new OcpiEmspTokenGetRequest($serverRequestInterface);
        $this->assertSame((new DateTime('25-05-2020'))->format(DateTime::ISO8601), $request->getDateFrom()->format(DateTime::ISO8601));
        $this->assertNull($request->getDateTo());
    }

    public function testShouldConstructWithDateTo(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface()
            ->withQueryParams([ 'offset' => '0', 'limit' => '10', 'date_to' => '25-05-2020']);

        $request = new OcpiEmspTokenGetRequest($serverRequestInterface);
        $this->assertSame((new DateTime('25-05-2020'))->format(DateTime::ISO8601), $request->getDateTo()->format(DateTime::ISO8601));
        $this->assertNull($request->getDateFrom());
    }

    public function testShouldConstructWithDates(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface()
            ->withQueryParams([ 'offset' => '0', 'limit' => '10', 'date_from' => '25-05-2020', 'date_to' => '26-05-2020']);

        $request = new OcpiEmspTokenGetRequest($serverRequestInterface);
        $this->assertSame((new DateTime('25-05-2020'))->format(DateTime::ISO8601), $request->getDateFrom()->format(DateTime::ISO8601));
        $this->assertSame((new DateTime('26-05-2020'))->format(DateTime::ISO8601), $request->getDateTo()->format(DateTime::ISO8601));
    }

    public function testShouldThrowWithInvalidDates(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface()
            ->withQueryParams([ 'offset' => '0', 'limit' => '10', 'date_from' => '26-05-2020', 'date_to' => '25-05-2020']);

        $this->expectException(InvalidArgumentException::class);
        new OcpiEmspTokenGetRequest($serverRequestInterface);
    }
}
