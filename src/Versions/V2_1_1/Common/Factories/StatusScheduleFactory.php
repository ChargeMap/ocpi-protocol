<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\EVSEStatus;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\StatusSchedule;
use DateTime;
use stdClass;

class StatusScheduleFactory
{
    public static function fromJson(?stdClass $json): ?StatusSchedule
    {
        if ($json === null) {
            return null;
        }

        return new StatusSchedule(
            new DateTime($json->period_begin),
            property_exists($json, 'period_end') ? new DateTime($json->period_end) : null,
            new EVSEStatus($json->status)
        );
    }
}
