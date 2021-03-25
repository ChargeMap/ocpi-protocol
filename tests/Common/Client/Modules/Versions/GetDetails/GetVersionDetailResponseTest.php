<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Common\Client\Modules\Versions\GetDetails;

use Chargemap\OCPI\Common\Client\Modules\Versions\GetAvailableVersions\GetAvailableVersionsResponse;
use Chargemap\OCPI\Common\Client\Modules\Versions\GetDetails\GetVersionDetailResponse;
use Chargemap\OCPI\Common\Client\OcpiVersion;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Tests\Chargemap\OCPI\Common\Factories\OcpiEndpointFactoryTest;
use Tests\Chargemap\OCPI\Common\Factories\VersionEndpointFactoryTest;
use Tests\Chargemap\OCPI\OcpiResponseTestCase;

class GetVersionDetailResponseTest extends OcpiResponseTestCase
{
    public function getFromResponseInterfaceData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/GetVersionDetailResponse/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/GetVersionDetailResponse/' . $filename),
                ];
            }
        }
    }

    /**
     * @dataProvider getFromResponseInterfaceData()
     * @covers \Chargemap\OCPI\Common\Client\Modules\Versions\GetDetails\GetVersionDetailResponse::fromResponseInterface()
     */
    public function testFromResponseInterface(string $payload): void
    {
        $json = json_decode($payload, false, 512, JSON_THROW_ON_ERROR);

        $responseInterface = $this->createResponseInterface($payload);

        $response = GetVersionDetailResponse::fromResponseInterface($responseInterface);

        foreach($json->data->endpoints as $index => $ocpiEndpoint) {
            Assert::assertEquals(OcpiVersion::fromVersionNumber($json->data->version), $response->getOcpiEndpoints()[$index]->getProtocolVersion());
            OcpiEndpointFactoryTest::assertOcpiEndpoint($ocpiEndpoint, $response->getOcpiEndpoints()[$index]);
        }
    }
}
