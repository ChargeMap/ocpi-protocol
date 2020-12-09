<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError;
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

        // If we follow strictly the protocol, it's either regular_hours xor twentyfourseven that is present.
        // But most CPOs set the flag to false when regular hours is present (a defect in the protocol leads to this misunderstanding)
        // Let's handle gracefully and compare only that there is no incoherency between the flag and the presence of regular hours
        $twentyFourSeven = property_exists($json, 'twentyfourseven') && $json->twentyfourseven !== null ? $json->twentyfourseven : false;
        $regularHours = property_exists($json, 'regular_hours') && $json->regular_hours !== null ? $json->regular_hours : [];

        if ($twentyFourSeven === true && count($regularHours ) > 0) {
            throw new OcpiInvalidPayloadClientError('Location cannot be always open and have regular hours in the same time');
        }

        if( $twentyFourSeven === false && count($regularHours) === 0) {
            throw new OcpiInvalidPayloadClientError('Location must be always open or have regular hours');
        }

        $hours = new Hours($twentyFourSeven);

        if ($regularHours !== null) {
            foreach ($regularHours as $jsonRegularHours) {
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