<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ExceptionalPeriod;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Hours;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\RegularHours;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Weekday;
use DateTime;
use stdClass;

class HoursFactory
{
    public static function fromJson(?stdClass $json): ?Hours
    {
        if ($json === null) {
            return null;
        }

        $hours = new Hours(property_exists($json, 'twentyfourseven') ? $json->twentyfourseven : false);

        if (property_exists($json, 'regular_hours')) {
            foreach ($json->regular_hours as $jsonRegularHours) {
                $hours->addHours(new RegularHours(
                    new Weekday($jsonRegularHours->weekday),
                    $jsonRegularHours->period_begin,
                    $jsonRegularHours->period_end
                ));
            }
        }

        if (property_exists($json, 'exceptional_openings')) {
            foreach ($json->exceptional_openings as $jsonOpenings) {
                $hours->addExceptionalOpening(new ExceptionalPeriod(
                    new DateTime($jsonOpenings->period_begin),
                    new DateTime($jsonOpenings->period_end)
                ));
            }
        }

        if (property_exists($json, 'exceptional_closings')) {
            foreach ($json->exceptional_closings as $jsonClosings) {
                $hours->addExceptionalClosing(new ExceptionalPeriod(
                    new DateTime($jsonClosings->period_begin),
                    new DateTime($jsonClosings->period_end)
                ));
            }
        }

        return $hours;
    }
}