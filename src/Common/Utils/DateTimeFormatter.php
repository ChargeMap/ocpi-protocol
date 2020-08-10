<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Utils;

use DateTime;
use DateTimeZone;

class DateTimeFormatter
{
    public static function format(?DateTime $date): ?string
    {
        if($date === null) {
            return null;
        }

        $defaultTimeZone = new DateTimeZone('UTC');

        // Force the format to UTC, as OCPI specifies that all timestamps should be expressed as UTC
        if($date->getTimezone() !== $defaultTimeZone ) {
            $date->setTimezone( $defaultTimeZone );
        }

        // As DateTime::ISO8601 exports with +00:00 and from the OCPI documentation, it is not the same as Zulu Time
        // (I think it's due to the DST maybe? but the OCPI documentation recommends using zulu time, so...)
        // See https://github.com/ocpi/ocpi/blob/master/releases/2.1.1/types.md#12-datetime-type for more information
        return $date->format('Y-m-d\TH:i:s\Z');
    }
}