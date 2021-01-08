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
use Exception;
use stdClass;

class PartialSessionFactory
{
    public static function fromJson(string $id,?stdClass $json): ?PartialSession
    {
        if ($json === null) {
            return null;
        }

        if (property_exists($json, 'id')) {
            if ($id !== $json->id) {
                throw new Exception("Unsupported patching of property id");
            }
        }

        $session = new PartialSession($id);

        if(property_exists($json, 'start_datetime')){
            $session->setStartDate(new DateTime($json->start_datetime));
        }
        if(property_exists($json, 'end_datetime')){
            $session->setEndDate(new DateTime($json->end_datetime));
        }
        if(property_exists($json,'kwh')){
            $session->setKwh($json->kwh);
        }
        if(property_exists($json,'auth_id')){
            $session->setAuthId($json->auth_id);
        }
        if(property_exists($json, 'auth_method')){
            $session->setAuthMethod(new AuthenticationMethod($json->auth_method));
        }
        if(property_exists($json, 'location')){
            $session->setLocation(LocationFactory::fromJson($json->location));
        }
        if(property_exists($json,'meter_id')){
            $session->setMeterId($json->meter_id);
        }
        if(property_exists($json,'currency')){
            $session->setCurrency($json->currency);
        }
        if(property_exists($json,'total_cost')) {
            $session->setTotalCost($json->total_cost);
        }
        if(property_exists($json, 'status')){
            $session->setStatus(new SessionStatus($json->status));
        }
        if(property_exists($json, 'last_updated')){
            $session->setLastUpdated(new DateTime($json->last_updated));
        }

        if (property_exists($json, 'charging_periods')) {
            $jsonChargingPeriods = $json->charging_periods;
            $session->setEmptyChargingPeriod();
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