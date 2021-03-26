<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Register;

use Chargemap\OCPI\Common\Client\OcpiConfiguration;
use Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Register\RegisterCredentialsRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Register\RegisterCredentialsService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Chargemap\OCPI\OcpiResponseTestCase;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories\CredentialsFactoryTest;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Register\RegisterCredentialsService
 */
class RegisterCredentialsServiceTest extends OcpiResponseTestCase
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
            ->setConstructorArgs([$this->configuration])
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

        $response = $this->createResponseInterface($payload);

        $this->service->expects(TestCase::once())->method('sendRequest')->with($request)->willReturn($response);

        $result = $this->service->handle($request);

        CredentialsFactoryTest::assertCredentials($json->data, $result->getCredentials());
    }
}
