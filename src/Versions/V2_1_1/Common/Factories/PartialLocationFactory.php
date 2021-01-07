<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\AdditionalGeoLocation;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Facility;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\GeoLocation;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\LocationType;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PartialLocation;
use DateTime;
use Exception;
use stdClass;

class PartialLocationFactory
{
    public static function fromJson(string $id, ?stdClass $json): ?PartialLocation
    {
        if ($json === null) {
            return null;
        }

        if (property_exists($json, 'id')) {
            if ($id !== $json->id) {
                throw new Exception("Unsupported patching of property id");
            }
        }

        $location = new PartialLocation($id);

        if (property_exists($json, 'type')) {
            $location->setLocationType(new LocationType($json->type));
        }
        if (property_exists($json, 'name')) {
            $location->setName($json->name);
        }
        if (property_exists($json, 'address')) {
            $location->setAddress($json->address);
        }
        if (property_exists($json, 'city')) {
            $location->setCity($json->city);
        }
        if (property_exists($json, 'postal_code')) {
            $location->setPostalCode($json->postal_code);
        }
        if (property_exists($json, 'country')) {
            $location->setCountry($json->country);
        }
        if (property_exists($json, 'coordinates')) {
            $location->setCoordinates(new GeoLocation($json->coordinates->latitude, $json->coordinates->longitude));
        }
        if (property_exists($json, 'operator')) {
            $location->setOperator(BusinessDetailsFactory::fromJson($json->operator));
        }
        if (property_exists($json, 'suboperator')) {
            $location->setSuboperator(BusinessDetailsFactory::fromJson($json->suboperator));
        }
        if (property_exists($json, 'owner')) {
            $location->setOwner(BusinessDetailsFactory::fromJson($json->owner));
        }
        if (property_exists($json, 'time_zone')) {
            $location->setTimeZone($json->time_zone);
        }
        if (property_exists($json, 'opening_times')) {
            $location->setOpeningTimes(HoursFactory::fromJson($json->opening_times));
        }
        if (property_exists($json, 'charging_when_closed')) {
            $location->setChargingWhenClosed($json->charging_when_closed);
        }
        if (property_exists($json, 'energy_mix')) {
            $location->setEnergyMix(EnergyMixFactory::fromJson($json->energy_mix));
        }
        if (property_exists($json, 'last_updated')) {
            $location->setLastUpdated(new DateTime($json->last_updated));
        }
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
