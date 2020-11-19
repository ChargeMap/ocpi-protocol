<?php

declare(strict_types=1);

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

        if (property_exists($json, 'regular_hours') && $json->regular_hours !== null) {
            foreach ($json->regular_hours as $jsonRegularHours) {
                $hours->addHours(RegularHoursFactory::fromJson($jsonRegularHours));
            }
        }

        if (property_exists($json, 'exceptional_openings') && $json->exceptional_openings !== null) {
            foreach ($json->exceptional_openings as $jsonOpenings) {
                $hours->addExceptionalOpening(ExceptionalPeriodFactory::fromJson($jsonOpenings));
            }
        }

        if (property_exists($json, 'exceptional_closings') && $json->exceptional_closings !== null) {
            foreach ($json->exceptional_closings as $jsonClosings) {
                $hours->addExceptionalClosing(ExceptionalPeriodFactory::fromJson($jsonClosings));
            }
        }

        return $hours;
    }
}