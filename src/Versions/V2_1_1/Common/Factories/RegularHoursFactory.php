<?php
declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\RegularHours;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Weekday;
use stdClass;

class RegularHoursFactory
{
    public static function fromJson(?stdClass $jsonRegularHours): ?RegularHours
    {
        if( $jsonRegularHours === null ) {
            return null;
        }

        return new RegularHours(
            new Weekday($jsonRegularHours->weekday),
            $jsonRegularHours->period_begin,
            $jsonRegularHours->period_end
        );
    }
}