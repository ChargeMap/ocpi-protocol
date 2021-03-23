<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Register;

use Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Register\RegisterCredentialsResponse;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\CredentialsFactory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories\CredentialsFactoryTest;

class RegisterCredentialsResponseTest extends TestCase
{
    public function getFromResponseInterfaceData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/RegisterCredentialsResponse/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/RegisterCredentialsResponse/' . $filename),
                ];
            }
        }
    }

    /**
     * @param string $payload
     * @throws \Chargemap\OCPI\Common\Client\Modules\Credentials\Register\ClientAlreadyRegisteredException
     * @throws \JsonException
     * @dataProvider getFromResponseInterfaceData()
     */
    public function testFromResponseInterface(string $payload): void
    {
        $streamInterface = $this->createMock(StreamInterface::class);

        // The body contents must be read
        $streamInterface->expects(TestCase::once())->method('__toString')->willReturn($payload);

        $responseInterface = $this->createMock(ResponseInterface::class);

        $responseInterface->expects(TestCase::atLeastOnce())->method('getBody')->willReturn($streamInterface);

        $json = json_decode($payload, false, 512, JSON_THROW_ON_ERROR);

        $credentialsResponse = RegisterCredentialsResponse::fromResponseInterface($responseInterface);

        CredentialsFactoryTest::assertCredentials($json->data, $credentialsResponse->getCredentials());
    }
}
