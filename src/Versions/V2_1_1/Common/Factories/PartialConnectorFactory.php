<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ConnectorFormat;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ConnectorType;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PartialConnector;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PowerType;
use DateTime;
use stdClass;

class PartialConnectorFactory
{
    public static function fromJson(?stdClass $json): ?PartialConnector
    {
        if ($json === null) {
            return null;
        }

        $connector = new PartialConnector();

        if (property_exists($json, 'id')) {
            $connector->withId($json->id);
        }
        if (property_exists($json, 'standard')) {
            $connector->withStandard(new ConnectorType($json->standard));
        }
        if (property_exists($json, 'format')) {
            $connector->withFormat(new ConnectorFormat($json->format));
        }
        if (property_exists($json, 'power_type')) {
            $connector->withPowerType(new PowerType($json->power_type));
        }
        if (property_exists($json, "voltage")) {
            $connector->withVoltage($json->voltage);
        }
        if (property_exists($json, "amperage")) {
            $connector->withAmperage($json->amperage);
        }
        if (property_exists($json, "tariff_id")) {
            $connector->withTariffId($json->tariff_id);
        }
        if (property_exists($json, "terms_and_conditions")) {
            $connector->withTermsAndConditions($json->terms_and_conditions);
        }
        if (property_exists($json, "last_updated")) {
            $connector->withLastUpdated(new DateTime($json->last_updated));
        }
        return $connector;
    }
}
