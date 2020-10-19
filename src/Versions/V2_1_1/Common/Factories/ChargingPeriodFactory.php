<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\CdrDimension;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\CdrDimensionType;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ChargingPeriod;
use DateTime;
use stdClass;

class ChargingPeriodFactory
{
    /**
     * @param stdClass[]|null $json
     * @return ChargingPeriod[]
     */
    public static function arrayFromJsonArray(?array $json): ?array
    {
        if ($json === null) {
            return null;
        }

        $chargingPeriods = [];

        foreach ($json as $jsonChargingPeriod) {
            $chargingPeriods[] = self::fromJson($jsonChargingPeriod);
        }

        return $chargingPeriods;
    }

    public static function fromJson(?stdClass $json): ?ChargingPeriod
    {
        if ($json === null) {
            return null;
        }

        $chargingPeriod = new ChargingPeriod(new DateTime($json->start_date_time));
        foreach ($json->dimensions as $jsonCdrDimension) {
            $chargingPeriod->addDimension(new CdrDimension(
                new CdrDimensionType($jsonCdrDimension->type),
                $jsonCdrDimension->volume
            ));
        }

        return $chargingPeriod;
    }
}
