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

        return new PartialConnector(
            $json->id ?? null,
            property_exists($json, 'standard') ? new ConnectorType($json->standard) : null,
            property_exists($json, 'format') ? new ConnectorFormat($json->format) : null,
            property_exists($json, 'power_type') ? new PowerType($json->power_type) : null,
            $json->voltage ?? null,
            $json->amperage ?? null,
            $json->tariff_id ?? null,
            $json->terms_and_conditions ?? null,
            property_exists($json, 'last_updated') ? new DateTime($json->last_updated) : null
        );
    }
}
