<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\AuthenticationMethod;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Session;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\SessionStatus;
use DateTime;
use stdClass;

class SessionFactory
{
    public static function fromJson(?stdClass $json): ?Session
    {
        if ($json === null) {
            return null;
        }

        $session = new Session(
            $json->id,
            new DateTime($json->start_datetime),
            property_exists($json, 'end_datetime') ? new DateTime($json->end_datetime) : null,
            $json->kwh,
            $json->auth_id,
            new AuthenticationMethod($json->auth_method),
            LocationFactory::fromJson($json->location),
            $json->meter_id ?? null,
            $json->currency,
            $json->total_cost ?? null,
            new SessionStatus($json->status),
            new DateTime($json->last_updated)
        );

        if (property_exists($json, 'charging_periods')) {
            foreach (ChargingPeriodFactory::arrayFromJsonArray($json->charging_periods) as $chargingPeriod) {
                $session->addChargingPeriod($chargingPeriod);
            }
        }

        return $session;
    }
}
