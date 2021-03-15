<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\ExceptionalPeriodFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ExceptionalPeriod;
use DateTime;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

class ExceptionalPeriodFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/ExceptionalPeriod/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/ExceptionalPeriod/' . $filename),
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

        $exceptionalPeriod = ExceptionalPeriodFactory::fromJson($json);

        self::assertExceptionalPeriod($json, $exceptionalPeriod);
    }

    public static function assertExceptionalPeriod(?stdClass $json, ?ExceptionalPeriod $exceptionalPeriod): void
    {
        if($json === null) {
            Assert::assertNull($exceptionalPeriod);
        } else {
            Assert::assertEquals(new DateTime($json->period_begin), $exceptionalPeriod->getPeriodBegin());
            Assert::assertEquals(new DateTime($json->period_end), $exceptionalPeriod->getPeriodEnd());
        }
    }
}