<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Common\Factories;

use Chargemap\OCPI\Common\Client\OcpiVersion;
use Chargemap\OCPI\Common\Factories\VersionEndpointFactory;
use Chargemap\OCPI\Common\Models\VersionEndpoint;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

class VersionEndpointFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/VersionEndpoint/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/VersionEndpoint/' . $filename),
                ];
            }
        }
    }

    /**
     * @param string $payload
     * @covers \Chargemap\OCPI\Versions\V2_1_1\Common\Factories\VersionEndpointFactory::fromJson()
     * @dataProvider getFromJsonData()
     */
    public function testFromJson(string $payload): void
    {
        $json = json_decode($payload, false, 512, JSON_THROW_ON_ERROR);

        $versionEndpoint = VersionEndpointFactory::fromJson($json);

        self::assertVersionEndpoint($json, $versionEndpoint);
    }

    public static function assertVersionEndpoint(?stdClass $json, ?VersionEndpoint $versionEndpoint)
    {
        if($json === null) {
            Assert::assertNull($versionEndpoint);
        } else {
            $uriFactory = Psr17FactoryDiscovery::findUriFactory();

            Assert::assertEquals($uriFactory->createUri($json->url), $versionEndpoint->getUri());
            Assert::assertEquals(OcpiVersion::fromVersionNumber($json->version), $versionEndpoint->getVersion());
        }
    }
}
