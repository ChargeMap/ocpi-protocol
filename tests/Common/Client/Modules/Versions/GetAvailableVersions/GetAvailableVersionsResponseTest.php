<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Common\Client\Modules\Versions\GetAvailableVersions;

use Chargemap\OCPI\Common\Client\Modules\Versions\GetAvailableVersions\GetAvailableVersionsResponse;
use Tests\Chargemap\OCPI\Common\Factories\VersionEndpointFactoryTest;
use Tests\Chargemap\OCPI\OcpiResponseTestCase;

/**
 * @covers \Chargemap\OCPI\Common\Client\Modules\Versions\GetAvailableVersions\GetAvailableVersionsResponse
 */
class GetAvailableVersionsResponseTest extends OcpiResponseTestCase
{
    public function getFromResponseInterfaceData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/GetAvailableVersionsResponse/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/GetAvailableVersionsResponse/' . $filename),
                ];
            }
        }
    }

    /**
     * @param string $payload
     * @dataProvider getFromResponseInterfaceData()
     */
    public function testFromResponseInterface(string $payload): void
    {
        $json = json_decode($payload, false, 512, JSON_THROW_ON_ERROR);

        $responseInterface = $this->createResponseInterface($payload);

        $versionsResponse = GetAvailableVersionsResponse::fromResponseInterface($responseInterface);

        foreach ($json->data as $index => $version) {
            VersionEndpointFactoryTest::assertVersionEndpoint($version, $versionsResponse->getVersions()[$index]);
        }
    }
}
