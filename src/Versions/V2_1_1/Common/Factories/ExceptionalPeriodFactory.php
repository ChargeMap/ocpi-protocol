<?php
declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ExceptionalPeriod;
use DateTime;
use stdClass;

class ExceptionalPeriodFactory
{
    public static function fromJson(?stdClass $json): ?ExceptionalPeriod
    {
        if($json === null ) {
            return null;
        }

        return new ExceptionalPeriod(
            new DateTime($json->period_begin),
            new DateTime($json->period_end)
        );
    }
}