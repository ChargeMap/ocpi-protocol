<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Register;

use Chargemap\OCPI\Common\Client\OcpiConfiguration;
use Chargemap\OCPI\Common\Client\OcpiEndpoint;
use Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Register\RegisterCredentialsRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Register\RegisterCredentialsService;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\CredentialsFactory;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories\CredentialsFactoryTest;

class RegisterCredentialsServiceTest extends TestCase
{
    /**
     * @var OcpiConfiguration|MockObject
     */
    private $configuration;

    /**
     * @var RegisterCredentialsService|MockObject
     */
    private $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->configuration = $this->createMock(OcpiConfiguration::class);

        $this->service = $this->getMockBuilder(RegisterCredentialsService::class)
            ->onlyMethods(['sendRequest'])
            ->disableOriginalConstructor()
            ->getMock();
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
        $json = json_decode($payload, false, 512, JSON_THROW_ON_ERROR);
        
        $request = $this->createMock(RegisterCredentialsRequest::class);

        // Emulate sendRequest()
        $body = $this->createMock(StreamInterface::class);

        $invokerCountMatcher = TestCase::once();

        $body->expects($invokerCountMatcher)->method('getContents')->willReturn($payload);
        $body->expects($invokerCountMatcher)->method('__toString')->willReturn($payload);

        $response = $this->createMock(ResponseInterface::class);
        $response->expects(TestCase::atLeastOnce())->method('getBody')->willReturn( $body );

        $this->service->expects(TestCase::once())->method('sendRequest')->with($request)->willReturn($response);

        $result = $this->service->handle($request);

        CredentialsFactoryTest::assertCredentials($json->data, $result->getCredentials());
    }
}
