<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Client\Versions\GetDetails;

use Chargemap\OCPI\Common\Client\OcpiVersion;
use Chargemap\OCPI\Versions\V2_1_1\Client\Versions\GetDetails\GetVersionDetailResponse;
use JsonException;
use PHPUnit\Framework\Assert;
use Tests\Chargemap\OCPI\OcpiResponseTestCase;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories\EndpointFactoryTest;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Client\Versions\GetDetails\GetAvailableVersionsResponse
 */
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
     * @param string $payload
     * @throws JsonException
     */
    public function testFromResponseInterface(string $payload): void
    {
        $json = json_decode($payload, false, 512, JSON_THROW_ON_ERROR);

        $responseInterface = $this->createResponseInterface($payload);

        $response = GetVersionDetailResponse::fromResponseInterface($responseInterface);

        Assert::assertEquals(OcpiVersion::fromVersionNumber($json->data->version), $response->getVersion());

        foreach($json->data->endpoints as $index => $ocpiEndpoint) {
            EndpointFactoryTest::assertEndpoint($ocpiEndpoint, $response->getEndpoints()[$index]);
        }
    }
}
