<?php

declare(strict_types=1);

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
            GeoLocationFactory::fromJson($json->coordinates),
            BusinessDetailsFactory::fromJson($json->operator ?? null),
            BusinessDetailsFactory::fromJson($json->suboperator ?? null),
            BusinessDetailsFactory::fromJson($json->owner ?? null),
            $json->time_zone ?? null,
            HoursFactory::fromJson($json->opening_times ?? null),
            $json->charging_when_closed ?? null,
            EnergyMixFactory::fromJson($json->energy_mix ?? null),
            new DateTime($json->last_updated)
        );

        if (property_exists($json, 'related_locations') && $json->related_locations !== null) {
            foreach ($json->related_locations as $jsonRelatedLocation) {
                $location->addRelatedLocation(AdditionalGeoLocationFactory::fromJson($jsonRelatedLocation));
            }
        }

        if (property_exists($json, 'evses') && $json->evses !== null) {
            foreach ($json->evses as $jsonEvse) {
                $location->addEVSE(EVSEFactory::fromJson($jsonEvse));
            }
        }

        if (property_exists($json, 'directions') && $json->directions !== null) {
            foreach ($json->directions as $jsonDirection) {
                $location->addDirection(DisplayTextFactory::fromJson($jsonDirection));
            }
        }

        if (property_exists($json, 'facilities') && $json->facilities !== null) {
            foreach ($json->facilities as $jsonFacility) {
                $location->addFacility(new Facility($jsonFacility));
            }
        }

        if (property_exists($json, 'images') && $json->images !== null) {
            foreach ($json->images as $jsonImage) {
                $location->addImage(ImageFactory::fromJson($jsonImage));
            }
        }

        return $location;
    }
}
