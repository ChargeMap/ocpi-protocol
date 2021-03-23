<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Register;

use Chargemap\OCPI\Common\Client\OcpiConfiguration;
use Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Register\RegisterCredentialsRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Register\RegisterCredentialsService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class RegisterCredentialsServiceTest extends TestCase
{
    /**
     * @var OcpiConfiguration|MockObject
     */
    private $configuration;

    private RegisterCredentialsService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->configuration = $this->createMock(OcpiConfiguration::class);

        $this->service = new RegisterCredentialsService($this->configuration);
    }

    public function getHandleData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/RegisterCredentialsService/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/RegisterCredentialsService/' . $filename),
                ];
            }
        }
    }

    /**
     * @param string $payload
     * @dataProvider getHandleData()
     */
    public function testHandle(string $payload): void
    {
        $json = json_decode($payload, true, 512, JSON_THROW_ON_ERROR);

        $request = $this->createMock(RegisterCredentialsRequest::class);

        // The service needs to take the json data from the request
        $request->expects(TestCase::atLeastOnce())->method('getServerRequestInterface');

        // The service must call a sendRequest()
        $body = $this->createMock(StreamInterface::class);

        $invokerCountMatcher = TestCase::once();

        $body->expects($invokerCountMatcher)->method('getContents')->willReturn($payload);
        $body->expects($invokerCountMatcher)->method('__toString')->willReturn($payload);

        $response = $this->createMock(ResponseInterface::class);
        $response->expects(TestCase::atLeastOnce())->method('getBody')->willReturn( $body );

        $httpClient = $this->createMock(ClientInterface::class);
        $httpClient->expects(TestCase::once())->method('sendRequest')->willReturn($response);

        $this->configuration->expects(TestCase::atLeastOnce())->method('getHttpClient')->willReturn($httpClient);

        $this->service->handle($request);
    }
}
