<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Common\Client\OcpiVersion;
use Chargemap\OCPI\Common\Models\BaseModuleId;
use Chargemap\OCPI\Common\Models\BaseEndpoint;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\EndpointFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Endpoint;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ModuleId;
use Http\Discovery\Psr17FactoryDiscovery;
use MyCLabs\Enum\Enum;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

class EndpointFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/Endpoint/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/Endpoint/' . $filename),
                ];
            }
        }
    }

    /**
     * @param string $payload
     * @dataProvider getFromJsonData()
     */
    public function testFromJson(string $payload): void
    {
        $json = json_decode($payload, false, 512, JSON_THROW_ON_ERROR);

        $endpoint = EndpointFactory::fromJson($json);

        self::assertEndpoint($json, $endpoint);
    }

    public static function assertEndpoint(?stdClass $json, ?Endpoint $endpoint)
    {
        if($json === null) {
            Assert::assertNull($endpoint);
        } else {
            $uriFactory = Psr17FactoryDiscovery::findUriFactory();

            Assert::assertEquals($json->url, $endpoint->getUrl());
            Assert::assertEquals(new ModuleId($json->identifier), $endpoint->getModuleId());
        }
    }
}
