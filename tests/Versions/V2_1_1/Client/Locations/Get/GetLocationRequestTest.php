<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Client\Locations\Get;

use Chargemap\OCPI\Versions\V2_1_1\Client\Locations\Get\GetLocationRequest;
use Http\Discovery\Psr17FactoryDiscovery;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Client\Locations\Get\GetLocationRequest
 */
class GetLocationRequestTest extends TestCase
{
    public function validParametersProvider(): iterable
    {
        yield ['1'];
        yield ['FR*55C*P92280*GAR*BUZENVAL'];
    }

    /**
     * @dataProvider validParametersProvider
     * @param string $locationId
     */
    public function testConstruct(string $locationId): void
    {
        $request = new GetLocationRequest($locationId);
        $this->assertSame($locationId, $request->getLocationId());
        $requestInterface = $request->getServerRequestInterface(Psr17FactoryDiscovery::findServerRequestFactory(),
            null);
        $this->assertSame('/' . $locationId, $requestInterface->getUri()->getPath());
    }

    public function invalidParametersProvider(): iterable
    {
        yield [''];
        yield ['FR*55C*P92280*GAR*BUZENVALFR*55C*P92280*GAR*BUZENVAL'];
    }

    /**
     * @dataProvider invalidParametersProvider
     * @param string $locationId
     */
    public function testThrowsOnInvalidParameters(string $locationId): void
    {
        $this->expectException(InvalidArgumentException::class);
        new GetLocationRequest($locationId);
    }
}
