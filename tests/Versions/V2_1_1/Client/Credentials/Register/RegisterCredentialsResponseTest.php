<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Register;

use Chargemap\OCPI\Common\Client\Modules\Credentials\Register\ClientAlreadyRegisteredException;
use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError;
use Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Register\RegisterCredentialsResponse;
use JsonException;
use Tests\Chargemap\OCPI\OcpiResponseTestCase;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories\CredentialsFactoryTest;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Register\RegisterCredentialsResponse
 */
class RegisterCredentialsResponseTest extends OcpiResponseTestCase
{
    public function getFromResponseInterfaceData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/RegisterCredentialsResponse/Valid') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/RegisterCredentialsResponse/Valid/' . $filename),
                ];
            }
        }
    }

    /**
     * @param string $payload
     * @throws ClientAlreadyRegisteredException
     * @throws JsonException
     * @dataProvider getFromResponseInterfaceData()
     */
    public function testFromResponseInterface(string $payload): void
    {
        $json = json_decode($payload, false, 512, JSON_THROW_ON_ERROR);

        $responseInterface = $this->createResponseInterface($payload);

        $credentialsResponse = RegisterCredentialsResponse::fromResponseInterface($responseInterface);

        CredentialsFactoryTest::assertCredentials($json->data, $credentialsResponse->getCredentials());
    }

    public function getFromResponseInterfaceExceptionData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/RegisterCredentialsResponse/Invalid') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/RegisterCredentialsResponse/Invalid/' . $filename),
                ];
            }
        }
    }

    /**
     * @param string $payload
     * @dataProvider getFromResponseInterfaceExceptionData()
     * @throws \Chargemap\OCPI\Common\Client\Modules\Credentials\Register\ClientAlreadyRegisteredException
     */
    public function testFromResponseInterfaceException(string $payload): void
    {
        $json = json_decode($payload);

        if ($json === null && json_last_error() !== null) {
            $this->expectException(OcpiInvalidPayloadClientError::class);
        }

        $responseInterface = $this->createResponseInterface($payload);

        RegisterCredentialsResponse::fromResponseInterface($responseInterface);
    }
}
