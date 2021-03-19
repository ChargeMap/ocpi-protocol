<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Common\Client;

use Chargemap\OCPI\Common\Client\Modules\AbstractRequest;
use Chargemap\OCPI\Common\Client\OcpiConfiguration;
use Chargemap\OCPI\Common\Client\ServiceFactory;
use Chargemap\OCPI\Versions\V2_1_1\Client\Locations\Get\GetLocationRequest as V2_1_1GetLocationRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Locations\Get\GetLocationService as V2_1_1GetLocationService;
use Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Get\GetTokenRequest as V2_1_1GetTokenRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Get\GetTokenService as V2_1_1GetTokenService;
use Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Patch\PatchTokenRequest as V2_1_1PatchTokenRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Patch\PatchTokenService as V2_1_1PatchTokenService;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PartialToken;
use PHPUnit\Framework\TestCase;

class ServiceFactoryTest extends TestCase
{
    public function requestAndExpectedServiceNameProvider(): iterable
    {
        yield [new V2_1_1GetLocationRequest('12345'), V2_1_1GetLocationService::class];
        yield [new V2_1_1GetTokenRequest('FR', 'CMP', '12345678'), V2_1_1GetTokenService::class];
        yield [
            new V2_1_1PatchTokenRequest('FR', 'CMP', '12345678', $this->createMock(PartialToken::class)),
            V2_1_1PatchTokenService::class
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
