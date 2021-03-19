<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Capability;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\EVSE;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\EVSEStatus;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\GeoLocation;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ParkingRestriction;
use DateTime;
use stdClass;

class EVSEFactory
{
    public static function fromJson(?stdClass $json): ?EVSE
    {
        if ($json === null) {
            return null;
        }

        $evse = new EVSE(
            $json->uid,
            property_exists($json, 'evse_id') ? $json->evse_id : null,
            new EVSEStatus($json->status),
            property_exists($json, 'floor_level') ? $json->floor_level : null,
            (property_exists($json, 'coordinates') && $json->coordinates !== null) ?
                new GeoLocation(
                    $json->coordinates->latitude,
                    $json->coordinates->longitude
                ) : null,
            property_exists($json, 'physical_reference') ? $json->physical_reference : null,
            new DateTime($json->last_updated)
        );

        if (property_exists($json, 'status_schedule') && $json->status_schedule !== null) {
            foreach ($json->status_schedule as $jsonStatusSchedule) {
                $evse->addStatusSchedule(StatusScheduleFactory::fromJson($jsonStatusSchedule));
            }
        }

        if (property_exists($json, 'capabilities') && $json->capabilities !== null) {
            foreach ($json->capabilities as $capability) {
                $evse->addCapability(new Capability($capability));
            }
        }

        if (property_exists($json, 'connectors') && $json->connectors !== null) {
            foreach ($json->connectors as $connector) {
                $evse->addConnector(ConnectorFactory::fromJson($connector));
            }
        }

        if (property_exists($json, 'directions') && $json->directions !== null) {
            foreach ($json->directions as $direction) {
                $evse->addDirection(DisplayTextFactory::fromJson($direction));
            }
        }

        if (property_exists($json, 'parking_restrictions') && $json->parking_restrictions !== null) {
            foreach ($json->parking_restrictions as $restriction) {
                $evse->addParkingRestriction(new ParkingRestriction($restriction));
            }
        }

        if (property_exists($json, 'images') && $json->images !== null) {
            foreach ($json->images as $image) {
                $evse->addImage(ImageFactory::fromJson($image));
            }
        }

        return $evse;
    }
}
