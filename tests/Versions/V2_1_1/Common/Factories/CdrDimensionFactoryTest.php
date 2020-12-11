<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\CdrDimensionFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\CdrDimension;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\CdrDimensionType;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

class CdrDimensionFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/CdrDimension/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/CdrDimension/' . $filename),
                ];
            }
        }
    }

    /**
     * @param string $payload
     * @throws \JsonException
     * @dataProvider getFromJsonData()
     */
    public function testFromJson(string $payload): void
    {
        $json = json_decode($payload, false, 512, JSON_THROW_ON_ERROR);

        $cdrDimension = CdrDimensionFactory::fromJson($json);

        self::assertCdrDimension($json, $cdrDimension);
    }

    public static function assertCdrDimension(?stdClass $json, ?CdrDimension $cdrDimension): void
    {
        if($json === null) {
            Assert::assertNull($cdrDimension);
        } else {
            Assert::assertEquals(new CdrDimensionType($json->type), $cdrDimension->getType());
            Assert::assertSame($json->volume, $cdrDimension->getVolume());
        }
    }
}