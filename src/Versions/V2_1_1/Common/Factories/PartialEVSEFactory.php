<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Capability;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\EVSEStatus;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\GeoLocation;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ParkingRestriction;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PartialEVSE;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\StatusSchedule;
use DateTime;
use stdClass;

class PartialEVSEFactory
{
    public static function fromJson(?stdClass $json): ?PartialEVSE
    {
        if ($json === null) {
            return null;
        }

        $evse = new PartialEVSE(
            $json->uid ?? null,
            $json->evse_id ?? null,
            property_exists($json, 'status') ? new EVSEStatus($json->status) : null,
            $json->floor_level ?? null,
            property_exists($json, 'coordinates') ?
                new GeoLocation(
                    $json->coordinates->latitude,
                    $json->coordinates->longitude
                ) : null,
            $json->physical_reference ?? null,
            property_exists($json, 'last_updated') ? new DateTime($json->last_updated) : null
        );

        if (property_exists($json, 'status_schedule')) {
            foreach ($json->status_schedule as $jsonStatusSchedule) {
                $evse->addStatusSchedule(new StatusSchedule(
                    new DateTime($jsonStatusSchedule->period_begin),
                    property_exists($jsonStatusSchedule, 'period_end') ? new DateTime($jsonStatusSchedule->period_end) : null,
                    new EVSEStatus($jsonStatusSchedule->status)
                ));
            }
        }

        if (property_exists($json, 'capabilities')) {
            foreach ($json->capabilities as $capability) {
                $evse->addCapability(new Capability($capability));
            }
        }

        if (property_exists($json, 'connectors')) {
            foreach ($json->connectors as $connector) {
                $evse->addConnector(ConnectorFactory::fromJson($connector));
            }
        }

        if (property_exists($json, 'directions')) {
            foreach ($json->directions as $direction) {
                $evse->addDirection(DisplayTextFactory::fromJson($direction));
            }
        }

        if (property_exists($json, 'parking_restrictions')) {
            foreach ($json->parking_restrictions as $restriction) {
                $evse->addParkingRestriction(new ParkingRestriction($restriction));
            }
        }

        if (property_exists($json, 'images')) {
            foreach ($json->images as $image) {
                $evse->addImage(ImageFactory::fromJson($image));
            }
        }

        return $evse;
    }
}
