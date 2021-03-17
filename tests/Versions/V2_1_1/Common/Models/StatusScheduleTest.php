<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\StatusSchedule;
use PHPUnit\Framework\Assert;
use stdClass;

class StatusScheduleTest
{
    public static function assertJsonSerialization(?StatusSchedule $statusSchedule, ?stdClass $json): void
    {
        if ($statusSchedule === null) {
            Assert::assertNull($json);
        } else {
            Assert::assertSame($statusSchedule->getStatus()->getValue(), $json->status);
            Assert::assertSame(DateTimeFormatter::format($statusSchedule->getPeriodBegin()), $json->period_begin);
            Assert::assertSame(DateTimeFormatter::format($statusSchedule->getPeriodEnd()), $json->period_end);
        }
    }
}
