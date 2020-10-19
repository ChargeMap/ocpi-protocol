<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use JsonSerializable;

class AdditionalGeoLocation implements JsonSerializable
{
    private GeoLocation $geoLocation;

    private ?DisplayText $name;

    public function __construct(GeoLocation $geoLocation, ?DisplayText $name)
    {
        $this->geoLocation = $geoLocation;
        $this->name = $name;
    }

    public function getGeoLocation(): GeoLocation
    {
        return $this->geoLocation;
    }

    public function getName(): ?DisplayText
    {
        return $this->name;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'latitude' => $this->geoLocation->getLatitude(),
            'longitude' => $this->geoLocation->getLongitude(),
        ];

        if ($this->name !== null) {
            $return['name'] = $this->name;
        }

        return $return;
    }
}
