<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ConnectorFormat;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ConnectorType;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PartialConnector;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PowerType;
use DateTime;
use Exception;
use stdClass;

class PartialConnectorFactory
{
    public static function fromJson(string $id,?stdClass $json): ?PartialConnector
    {
        if ($json === null) {
            return null;
        }

        if(property_exists($json,'id')) {
            if($id !== $json->id){
                throw new Exception("Unsupported patching of property id");
            }
        }

        $connector = new PartialConnector($id);

        if(property_exists($json, 'standard')){
            $connector->setStandard(new ConnectorType($json->standard));
        }
        if(property_exists($json,'format')){
            $connector->setFormat(new ConnectorFormat($json->format));
        }
        if(property_exists($json, 'power_type')){
            $connector->setPowerType(new PowerType($json->power_type));
        }
        if(property_exists($json,"voltage")){
            $connector->setVoltage($json->voltage);
        }
        if(property_exists($json,"amperage")){
            $connector->setAmperage($json->amperage);
        }
        if(property_exists($json,"tariff_id")){
            $connector->setTariffId($json->tariff_id);
        }
        if(property_exists($json,"terms_and_conditions")){
            $connector->setTermsAndConditions($json->terms_and_conditions);
        }
        if(property_exists($json,"last_updated")){
            $connector->setLastUpdated(new DateTime($json->last_updated));
        }
        return $connector;
    }
}
