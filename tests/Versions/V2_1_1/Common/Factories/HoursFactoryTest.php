<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Common\Server\Errors\OcpiError;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\HoursFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Hours;
use JsonException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;
use Tests\Chargemap\OCPI\InvalidPayloadException;
use Tests\Chargemap\OCPI\OcpiTestCase;

class HoursFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/Hours/Valid/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/Hours/Valid/' . $filename),
                ];
            }
        }
    }

    /**
     * @param string $payload
     * @throws JsonException|InvalidPayloadException
     * @dataProvider getFromJsonData()
     */
    public function testFromJson(string $payload): void
    {
        $json = json_decode($payload, false, 512, JSON_THROW_ON_ERROR);

        OcpiTestCase::coerce( realpath( __DIR__.'/../../../../../src/Versions/V2_1_1/Server/Emsp/Schemas/common.json' ). '#/definitions/hours', $json );

        $hours = HoursFactory::fromJson($json);

        self::assertHours($json, $hours);
    }

    public static function assertHours(?stdClass $json, ?Hours $hours): void
    {
        if($json === null) {
            Assert::assertNull($hours);
        } else {
            Assert::assertSame($json->twentyfourseven ?? false, $hours->isTwentyFourSeven());

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

    public function getFromJsonExceptionsData()
    {
        foreach (scandir(__DIR__ . '/Payloads/Hours/Invalid/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/Hours/Invalid/' . $filename),
                ];
            }
        }
    }

    /**
     * @param string $payload
     * @dataProvider getFromJsonExceptionsData()
     * @throws JsonException
     */
    public function testFromJsonExceptions(string $payload): void
    {
        $this->expectException(OcpiError::class);

        $json = json_decode($payload, false, 512, JSON_THROW_ON_ERROR);

        HoursFactory::fromJson($json);
    }
}