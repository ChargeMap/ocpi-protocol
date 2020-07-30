<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\AdditionalGeoLocation;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Facility;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\GeoLocation;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Location;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\LocationType;
use DateTime;
use stdClass;

class LocationFactory
{
    public static function fromJson(?stdClass $json): ?Location
    {
        if ($json === null) {
            return null;
        }

        $location = new Location(
            $json->id,
            new LocationType($json->type),
            $json->name ?? null,
            $json->address,
            $json->city,
            $json->postal_code,
            $json->country,
            new GeoLocation($json->coordinates->latitude, $json->coordinates->longitude),
            BusinessDetailsFactory::fromJson($json->operator ?? null),
            BusinessDetailsFactory::fromJson($json->suboperator ?? null),
            BusinessDetailsFactory::fromJson($json->owner ?? null),
            $json->time_zone ?? null,
            HoursFactory::fromJson($json->opening_times ?? null),
            $json->charging_when_closed ?? null,
            EnergyMixFactory::fromJson($json->energy_mix ?? null),
            new DateTime($json->last_updated)
        );

        if (property_exists($json, 'related_locations')) {
            foreach ($json->related_locations as $jsonRelatedLocation) {
                $location->addRelatedLocation(new AdditionalGeoLocation(
                    new GeoLocation(
                        $jsonRelatedLocation->latitude,
                        $jsonRelatedLocation->longitude
                    ),
                    DisplayTextFactory::fromJson($jsonRelatedLocation->name)
                ));
            }
        }

        if (property_exists($json, 'evses')) {
            foreach ($json->evses as $jsonEvse) {
                $location->addEVSE(EVSEFactory::fromJson($jsonEvse));
            }
        }

        if (property_exists($json, 'directions')) {
            foreach ($json->directions as $jsonDirection) {
                $location->addDirection(DisplayTextFactory::fromJson($jsonDirection));
            }
        }

        if (property_exists($json, 'facilities')) {
            foreach ($json->facilities as $jsonFacility) {
                $location->addFacility(new Facility($jsonFacility));
            }
        }

        if (property_exists($json, 'images')) {
            foreach ($json->images as $jsonImage) {
                $location->addImage(ImageFactory::fromJson($jsonImage));
            }
        }

        return $location;
    }
}
