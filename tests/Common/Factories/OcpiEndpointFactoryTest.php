<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Common\Factories;

use Chargemap\OCPI\Common\Client\OcpiModule;
use Chargemap\OCPI\Common\Client\OcpiVersion;
use Chargemap\OCPI\Common\Factories\OcpiEndpointFactory;
use Chargemap\OCPI\Common\Models\OcpiEndpoint;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

class OcpiEndpointFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/OcpiEndpoint/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/OcpiEndpoint/' . $filename),
                ];
            }
        }
    }

    /**
     * @param string $payload
     * @covers OcpiEndpointFactory::fromJson()
     * @dataProvider getFromJsonData()
     */
    public function testFromJson(string $payload): void
    {
        $json = json_decode($payload, false, 512, JSON_THROW_ON_ERROR);

        $ocpiEndpoint = OcpiEndpointFactory::fromJson(OcpiVersion::V2_1_1(), $json);

        self::assertOcpiEndpoint($json, $ocpiEndpoint);
    }

    public static function assertOcpiEndpoint(?stdClass $json, ?OcpiEndpoint $ocpiEndpoint)
    {
        if($json === null) {
            Assert::assertNull($ocpiEndpoint);
        } else {
            $uriFactory = Psr17FactoryDiscovery::findUriFactory();

            Assert::assertEquals($uriFactory->createUri($json->url), $ocpiEndpoint->getUri());
            Assert::assertEquals(new OcpiModule($json->identifier), $ocpiEndpoint->getModule());
        }
    }
}
