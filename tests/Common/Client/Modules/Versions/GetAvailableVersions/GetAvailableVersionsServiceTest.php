<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Common\Client\Modules\Versions\GetAvailableVersions;

use Chargemap\OCPI\Common\Client\Modules\Versions\GetAvailableVersions\GetAvailableVersionsRequest;
use Chargemap\OCPI\Common\Client\Modules\Versions\GetAvailableVersions\GetAvailableVersionsService;
use Chargemap\OCPI\Common\Client\OcpiConfiguration;
use Chargemap\OCPI\Common\Factories\VersionEndpointFactory;
use Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Register\RegisterCredentialsRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Register\RegisterCredentialsService;
use Http\Client\HttpClient;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Tests\Chargemap\OCPI\Common\Factories\VersionEndpointFactoryTest;
use Tests\Chargemap\OCPI\OcpiResponseTestCase;

class GetAvailableVersionsServiceTest extends OcpiResponseTestCase
{
    /**
     * @var OcpiConfiguration|MockObject
     */
    private $configuration;

    /**
     * @var GetAvailableVersionsService|MockObject
     */
    private $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->configuration = $this->createMock(OcpiConfiguration::class);

        $this->service = $this->getMockBuilder(GetAvailableVersionsService::class)
            ->onlyMethods(['addAuthorization'])
            ->setConstructorArgs([$this->configuration])
            ->getMock();
    }

    public function getGetData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/GetAvailableVersionsService/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/GetAvailableVersionsService/' . $filename),
                ];
            }
        }
    }

    /**
     * @param string $payload
     * @covers \Chargemap\OCPI\Common\Client\Modules\Versions\GetAvailableVersions\GetAvailableVersionsService::get()
     * @dataProvider getGetData()
     */
    public function testGet(string $payload): void
    {
        $json = json_decode($payload, false, 512, JSON_THROW_ON_ERROR);

        $serverRequestInterface = $this->createMock(ServerRequestInterface::class);

        $request = $this->createMock(GetAvailableVersionsRequest::class);
        $request->expects(TestCase::atLeastOnce())->method('getServerRequestInterface')->willReturn($serverRequestInterface);

        $response = $this->createResponseInterface($payload);

        // Must call the HTTP client
        $httpClient = $this->createMock(HttpClient::class);
        $httpClient->expects(TestCase::once())->method('sendRequest')->willReturn($response);

        $this->configuration->expects(TestCase::once())->method('getHttpClient')->willReturn($httpClient);

        // Must add authorization to the request
        $this->service->expects(TestCase::once())->method('addAuthorization')->with($serverRequestInterface)->willReturn($serverRequestInterface);

        $response = $this->service->get($request);

        foreach($json->data as $index => $availableVersion) {
            VersionEndpointFactoryTest::assertVersionEndpoint($availableVersion, $response->getVersions()[$index]);
        }
    }
}
