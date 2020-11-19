<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\BusinessDetailsFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\StatusScheduleFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\BusinessDetails;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\EVSEStatus;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\StatusSchedule;
use DateTime;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

class StatusScheduleFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/StatusSchedule/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/StatusSchedule/' . $filename),
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

        $statusSchedule = StatusScheduleFactory::fromJson($json);

        self::assertStatusSchedule($json, $statusSchedule);
    }

    public static function assertStatusSchedule(?stdClass $json, ?StatusSchedule $statusSchedule): void
    {
        if($json === null) {
            Assert::assertNull($statusSchedule);
        } else {
            Assert::assertEquals(new EVSEStatus($json->status), $statusSchedule->getStatus());
            Assert::assertEquals(new DateTime($json->period_begin), $statusSchedule->getPeriodBegin());
            Assert::assertEquals(new DateTime($json->period_end), $statusSchedule->getPeriodEnd());
        }
    }
}