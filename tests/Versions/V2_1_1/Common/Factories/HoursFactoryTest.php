<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\HoursFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\BusinessDetails;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Hours;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

class HoursFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/Hours/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/Hours/' . $filename),
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

        $hours = HoursFactory::fromJson($json);

        self::assertHours($json, $hours);
    }

    public static function assertHours(?stdClass $json, ?Hours $hours): void
    {
        if($json === null) {
            Assert::assertNull($hours);
        } else {
            Assert::assertSame($json->twentyfourseven, $hours->isTwentyFourSeven());

            if(!property_exists($json, 'regular_hours') || $json->regular_hours === null ) {
                Assert::assertCount(0, $hours->getRegularHours());
            } else {
                foreach($json->regular_hours as $index => $regularHour) {
                    RegularHoursFactoryTest::assertRegularHours($regularHour, $hours->getRegularHours()[$index]);
                }
            }

            if(!property_exists($json, 'exceptional_openings') || $json->exceptional_openings === null ) {
                Assert::assertCount(0, $hours->getExceptionalOpenings());
            } else {
                foreach($json->exceptional_openings as $index => $exceptionalOpening) {
                    ExceptionalPeriodFactoryTest::assertExceptionalPeriod($exceptionalOpening, $hours->getExceptionalOpenings()[$index]);
                }
            }

            if(!property_exists($json, 'exceptional_closings') || $json->exceptional_closings === null ) {
                Assert::assertCount(0, $hours->getExceptionalClosings());
            } else {
                foreach($json->exceptional_closings as $index => $exceptionalClosing) {
                    ExceptionalPeriodFactoryTest::assertExceptionalPeriod($exceptionalClosing, $hours->getExceptionalClosings()[$index]);
                }
            }
        }
    }
}