<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Connector;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ConnectorFormat;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ConnectorType;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PowerType;
use DateTime;
use stdClass;

class ConnectorFactory
{
    public static function fromJson(?stdClass $json): ?Connector
    {
        if ($json === null) {
            return null;
        }

        return new Connector(
            $json->id,
            new ConnectorType($json->standard),
            new ConnectorFormat($json->format),
            new PowerType($json->power_type),
            $json->voltage,
            $json->amperage,
            property_exists($json, 'tariff_id') ? $json->tariff_id : null,
            property_exists($json, 'terms_and_conditions') ? $json->terms_and_conditions : null,
            new DateTime($json->last_updated)
        );
    }
}
