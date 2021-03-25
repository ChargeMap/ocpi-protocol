<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Register;

use Chargemap\OCPI\Versions\V2_1_1\Client\Credentials\Register\RegisterCredentialsRequest;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Credentials;
use Http\Discovery\Psr17FactoryDiscovery;
use JsonException;
use PHPUnit\Framework\TestCase;
use Tests\Chargemap\OCPI\InvalidPayloadException;
use Tests\Chargemap\OCPI\OcpiTestCase;

class RegisterCredentialsRequestTest extends TestCase
{
    public function getGetServerRequestInterfaceData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/RegisterCredentialsRequest/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/RegisterCredentialsRequest/' . $filename),
                ];
            }
        }
    }

    /**
     * @dataProvider getGetServerRequestInterfaceData()
     * @throws InvalidPayloadException
     * @throws JsonException
     */
    public function testGetServerRequestInterface(string $payload): void
    {
        $json = json_decode($payload, true, 512, JSON_THROW_ON_ERROR);
        OcpiTestCase::coerce('V2_1_1/Common/credentials.schema.json', json_decode($payload));

        $credentials = $this->createMock(Credentials::class);
        $credentials->expects(TestCase::atLeastOnce())->method('jsonSerialize')->willReturn($json);

        $registerCredentialsRequest = new RegisterCredentialsRequest($credentials);

        $serverRequestInterface = $registerCredentialsRequest->getServerRequestInterface(Psr17FactoryDiscovery::findServerRequestFactory(), null);

        self::assertJsonStringEqualsJsonString($payload, $serverRequestInterface->getBody()->getContents());
    }
}
