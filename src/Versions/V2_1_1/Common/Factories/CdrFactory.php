<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\AuthenticationMethod;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Cdr;
use DateTime;
use stdClass;

class CdrFactory
{
    public static function fromJson(?stdClass $json): ?Cdr
    {
        if ($json === null) {
            return null;
        }

        $cdr = new Cdr(
            $json->id,
            new DateTime($json->start_date_time),
            new DateTime($json->stop_date_time),
            $json->auth_id,
            new AuthenticationMethod($json->auth_method),
            LocationFactory::fromJson($json->location),
            $json->meter_id ?? null,
            $json->currency,
            $json->total_cost,
            $json->total_energy,
            $json->total_time,
            $json->total_parking_time ?? null,
            $json->remark ?? null,
            new DateTime($json->last_updated)
        );

        if (property_exists($json, 'tariffs')) {
            foreach (TariffFactory::arrayFromJsonArray($json->tariffs) as $tariff) {
                $cdr->addTariff($tariff);
            }
        }

        if (property_exists($json, 'charging_periods')) {
            foreach (ChargingPeriodFactory::arrayFromJsonArray($json->charging_periods) as $chargingPeriod) {
                $cdr->addChargingPeriod($chargingPeriod);
            }
        }

        return $cdr;
    }
}
