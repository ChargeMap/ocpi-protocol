<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\AuthenticationMethod;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\CdrDimension;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\CdrDimensionType;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ChargingPeriod;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PartialSession;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\SessionStatus;
use DateTime;
use stdClass;

class PartialSessionFactory
{
    public static function fromJson(?stdClass $json): ?PartialSession
    {
        if ($json === null) {
            return null;
        }

        $session = new PartialSession(
            $json->id ?? null,
            property_exists($json, 'start_datetime') ? new DateTime($json->start_datetime) : null,
            property_exists($json, 'end_datetime') ? new DateTime($json->end_datetime) : null,
            $json->kwh ?? null,
            $json->auth_id ?? null,
            property_exists($json, 'auth_method') ? new AuthenticationMethod($json->auth_method) : null,
            property_exists($json, 'location') ? LocationFactory::fromJson($json->location) : null,
            $json->meter_id ?? null,
            $json->currency ?? null,
            $json->total_cost ?? null,
            property_exists($json, 'status') ? new SessionStatus($json->status) : null,
            property_exists($json, 'last_updated') ? new DateTime($json->last_updated) : null
        );

        if (property_exists($json, 'charging_periods')) {
            $jsonChargingPeriods = $json->charging_periods;
            foreach ($jsonChargingPeriods as $jsonChargingPeriod) {
                $chargingPeriod = new ChargingPeriod(new DateTime($jsonChargingPeriod->start_date_time));
                foreach ($jsonChargingPeriod->dimensions as $jsonCdrDimension) {
                    $chargingPeriod->addDimension(new CdrDimension(
                        new CdrDimensionType($jsonCdrDimension->type),
                        $jsonCdrDimension->volume
                    ));
                }
                $session->addChargingPeriod($chargingPeriod);
            }
        }

        return $session;
    }
}