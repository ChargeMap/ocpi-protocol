<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Facility;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\GeoLocation;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\LocationType;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PartialLocation;
use DateTime;
use stdClass;

class PartialLocationFactory
{
    public static function fromJson(?stdClass $json): ?PartialLocation
    {
        if ($json === null) {
            return null;
        }

        $location = new PartialLocation();

        if (property_exists($json, 'id')) {
            $location->withId($json->id);
        }
        if (property_exists($json, 'type')) {
            $location->withLocationType(new LocationType($json->type));
        }
        if (property_exists($json, 'name')) {
            $location->withName($json->name);
        }
        if (property_exists($json, 'address')) {
            $location->withAddress($json->address);
        }
        if (property_exists($json, 'city')) {
            $location->withCity($json->city);
        }
        if (property_exists($json, 'postal_code')) {
            $location->withPostalCode($json->postal_code);
        }
        if (property_exists($json, 'country')) {
            $location->withCountry($json->country);
        }
        if (property_exists($json, 'coordinates')) {
            $location->withCoordinates(new GeoLocation($json->coordinates->latitude, $json->coordinates->longitude));
        }
        if (property_exists($json, 'operator')) {
            $location->withOperator(BusinessDetailsFactory::fromJson($json->operator));
        }
        if (property_exists($json, 'suboperator')) {
            $location->withSuboperator(BusinessDetailsFactory::fromJson($json->suboperator));
        }
        if (property_exists($json, 'owner')) {
            $location->withOwner(BusinessDetailsFactory::fromJson($json->owner));
        }
        if (property_exists($json, 'time_zone')) {
            $location->withTimeZone($json->time_zone);
        }
        if (property_exists($json, 'opening_times')) {
            $location->withOpeningTimes(HoursFactory::fromJson($json->opening_times));
        }
        if (property_exists($json, 'charging_when_closed')) {
            $location->withChargingWhenClosed($json->charging_when_closed);
        }
        if (property_exists($json, 'energy_mix')) {
            $location->withEnergyMix(EnergyMixFactory::fromJson($json->energy_mix));
        }
        if (property_exists($json, 'last_updated')) {
            $location->withLastUpdated(new DateTime($json->last_updated));
        }
        if (property_exists($json, 'related_locations')) {
            $location->withRelatedLocations();
            foreach ($json->related_locations  ?? [] as $jsonRelatedLocation) {
                $location->withRelatedLocation(AdditionalGeoLocationFactory::fromJson($jsonRelatedLocation));
            }
        }
        if (property_exists($json, 'evses')) {
            $location->withEvses();
            foreach ($json->evses ?? [] as $jsonEvse) {
                $location->withEvse(EVSEFactory::fromJson($jsonEvse));
            }
        }
        if (property_exists($json, 'directions')) {
            $location->withDirections();
            foreach ($json->directions ?? [] as $jsonDirection) {
                $location->withDirection(DisplayTextFactory::fromJson($jsonDirection));
            }
        }
        if (property_exists($json, 'facilities')) {
            $location->withFacilities();
            foreach ($json->facilities ?? [] as $jsonFacility) {
                $location->withFacility(new Facility($jsonFacility));
            }
        }
        if (property_exists($json, 'images')) {
            $location->withImages();
            foreach ($json->images ?? [] as $jsonImage) {
                $location->withImage(ImageFactory::fromJson($jsonImage));
            }
        }

        return $location;
    }
}
