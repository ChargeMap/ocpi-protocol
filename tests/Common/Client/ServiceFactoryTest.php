<?php

namespace Tests\Chargemap\OCPI\Common\Client;

use Chargemap\OCPI\Common\Client\Modules\AbstractRequest;
use Chargemap\OCPI\Common\Client\OcpiConfiguration;
use Chargemap\OCPI\Common\Client\ServiceFactory;
use Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Get\GetTokenRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Get\GetTokenService;
use Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Patch\PatchTokenRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Patch\PatchTokenService;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PartialToken;
use PHPUnit\Framework\TestCase;

class ServiceFactoryTest extends TestCase
{
    public function requestAndExpectedServiceNameProvider(): iterable
    {

        yield [new GetTokenRequest('FR', 'CMP', '12345678'), GetTokenService::class];
        yield [
            new PatchTokenRequest('FR', 'CMP', '12345678', $this->createMock(PartialToken::class)),
            PatchTokenService::class
        ];
    }

    /**
     * @dataProvider requestAndExpectedServiceNameProvider
     * @param AbstractRequest $request
     * @param string $expectedServiceName
     */
    public function testShouldReturnCorrectService(
        AbstractRequest $request,
        string $expectedServiceName
    ): void {
        $configuration = new OcpiConfiguration('token');
        $service = ServiceFactory::from($request, $configuration);

        $this->assertSame(get_class($service), $expectedServiceName);
    }
}
