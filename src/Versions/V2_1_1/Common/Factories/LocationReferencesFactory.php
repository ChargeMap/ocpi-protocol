<?php
declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Location;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\LocationReferences;
use stdClass;

class LocationReferencesFactory
{
    public static function fromJson(?stdClass $json): ?LocationReferences
    {
        if ($json === null) {
            return null;
        }

        $result = new LocationReferences($json->location_id);

        if (property_exists($json, 'evse_uids') && is_array($json->evse_uids)) {
            foreach ($json->evse_uids as $evseUid) {
                $result->addEvseUid($evseUid);
            }
        }

        if (property_exists($json, 'connector_ids') && is_array($json->connector_ids)) {
            foreach ($json->connector_ids as $connectorId) {
                $result->addConnectorId($connectorId);
            }
        }

        return $result;
    }
}