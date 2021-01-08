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

        $session = new PartialSession();

        if (property_exists($json, 'id')) {
            $session->withId($json->id);
        }
        if (property_exists($json, 'start_datetime')) {
            $session->withStartDate(new DateTime($json->start_datetime));
        }
        if (property_exists($json, 'end_datetime')) {
            $session->withEndDate(new DateTime($json->end_datetime));
        }
        if (property_exists($json, 'kwh')) {
            $session->withKwh($json->kwh);
        }
        if (property_exists($json, 'auth_id')) {
            $session->withAuthId($json->auth_id);
        }
        if (property_exists($json, 'auth_method')) {
            $session->withAuthMethod(new AuthenticationMethod($json->auth_method));
        }
        if (property_exists($json, 'location')) {
            $session->withLocation(LocationFactory::fromJson($json->location));
        }
        if (property_exists($json, 'meter_id')) {
            $session->withMeterId($json->meter_id);
        }
        if (property_exists($json, 'currency')) {
            $session->withCurrency($json->currency);
        }
        if (property_exists($json, 'total_cost')) {
            $session->withTotalCost($json->total_cost);
        }
        if (property_exists($json, 'status')) {
            $session->withStatus(new SessionStatus($json->status));
        }
        if (property_exists($json, 'last_updated')) {
            $session->withLastUpdated(new DateTime($json->last_updated));
        }

        if (property_exists($json, 'charging_periods')) {
            $jsonChargingPeriods = $json->charging_periods;
            $session->withEmptyChargingPeriod();
            foreach ($jsonChargingPeriods ?? [] as $jsonChargingPeriod) {
                $chargingPeriod = new ChargingPeriod(new DateTime($jsonChargingPeriod->start_date_time));
                foreach ($jsonChargingPeriod->dimensions as $jsonCdrDimension) {
                    $chargingPeriod->addDimension(new CdrDimension(
                        new CdrDimensionType($jsonCdrDimension->type),
                        $jsonCdrDimension->volume
                    ));
                }
                $session->withChargingPeriod($chargingPeriod);
            }
        }

        return $session;
    }
}