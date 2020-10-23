<?php

namespace Tests\Chargemap\OCPI\Common\Client\Modules;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use ReflectionMethod;

class AbstractFeaturesTest extends TestCase
{
    public function abstractRequestUriProvider(): iterable
    {
        yield ['?limit=20&offset=0'];
        yield ['/EN/ABC/token_uid'];
        yield ['/EN/ABC/token_uid?limit=20&offset=0']; //Is not real example, just make sure query parameters are applied too
    }

    /**
     * @dataProvider abstractRequestUriProvider
     * @param string $stringUri
     */
    public function testShouldConstructCorrectUri(string $stringUri): void
    {
        //Given
        $forgeUriMethod = new ReflectionMethod(AbstractFeatures::class, 'forgeUri');
        $forgeUriMethod->setAccessible(true);
        $baseEndpoint = Psr17FactoryDiscovery::findUriFactory()->createUri('https://example.com/ocpi/cpo/2.1.1/tokens');
        $requestUri = Psr17FactoryDiscovery::findUriFactory()->createUri($stringUri);

        //When
        /** @var UriInterface $uri */
        $uri = $forgeUriMethod->invoke(null, $baseEndpoint, $requestUri);

        //Then
        $this->assertSame('https://example.com/ocpi/cpo/2.1.1/tokens' . $stringUri, $uri->__toString());
    }
}
