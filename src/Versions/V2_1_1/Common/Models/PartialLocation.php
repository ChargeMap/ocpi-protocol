<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use DateTime;
use JsonSerializable;

class PartialLocation implements JsonSerializable
{
    private ?string $id;

    private ?LocationType $locationType;

    private ?string $name;

    private ?string $address;

    private ?string $city;

    private ?string $postalCode;

    private ?string $country;

    private ?GeoLocation $coordinates;

    /** @var AdditionalGeoLocation[]|null */
    private ?array $relatedLocations = null;

    /** @var EVSE[]|null */
    private ?array $evses = null;

    /** @var DisplayText[]|null */
    private ?array $directions = null;

    private ?BusinessDetails $operator;

    private ?BusinessDetails $suboperator;

    private ?BusinessDetails $owner;

    /** @var Facility[]|null */
    private ?array $facilities = null;

    private ?string $timeZone;

    private ?Hours $openingTimes;

    private ?bool $chargingWhenClosed;

    /** @var Image[]|null */
    private ?array $images = null;

    private ?EnergyMix $energyMix;

    private ?DateTime $lastUpdated;

    public function __construct(
        ?string $id,
        ?LocationType $locationType,
        ?string $name,
        ?string $address,
        ?string $city,
        ?string $postalCode,
        ?string $country,
        ?GeoLocation $coordinates,
        ?BusinessDetails $operator,
        ?BusinessDetails $suboperator,
        ?BusinessDetails $owner,
        ?string $timeZone,
        ?Hours $openingTimes,
        ?bool $chargingWhenClosed,
        ?EnergyMix $energyMix,
        ?DateTime $lastUpdated
    )
    {
        $this->id = $id;
        $this->locationType = $locationType;
        $this->name = $name;
        $this->address = $address;
        $this->city = $city;
        $this->postalCode = $postalCode;
        $this->country = $country;
        $this->coordinates = $coordinates;
        $this->operator = $operator;
        $this->suboperator = $suboperator;
        $this->owner = $owner;
        $this->timeZone = $timeZone;
        $this->openingTimes = $openingTimes;
        $this->chargingWhenClosed = $chargingWhenClosed;
        $this->energyMix = $energyMix;
        $this->lastUpdated = $lastUpdated;
    }


    public function addRelatedLocation(AdditionalGeoLocation $relatedLocation): self
    {
        $this->relatedLocations[] = $relatedLocation;

        return $this;
    }

    public function addEVSE(EVSE $evse): self
    {
        $this->evses[] = $evse;

        return $this;
    }

    public function addDirection(DisplayText $direction): self
    {
        $this->directions[] = $direction;

        return $this;
    }

    public function addFacility(Facility $facility): self
    {
        $this->facilities[] = $facility;

        return $this;
    }

    public function addImage(Image $image): self
    {
        $this->images[] = $image;

        return $this;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getLocationType(): ?LocationType
    {
        return $this->locationType;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function getCoordinates(): ?GeoLocation
    {
        return $this->coordinates;
    }

    /**
     * @return AdditionalGeoLocation[]|null
     */
    public function getRelatedLocations(): ?array
    {
        return $this->relatedLocations;
    }

    /**
     * @return EVSE[]|null
     */
    public function getEvses(): ?array
    {
        return $this->evses;
    }

    /**
     * @return DisplayText[]|null
     */
    public function getDirections(): ?array
    {
        return $this->directions;
    }

    public function getOperator(): ?BusinessDetails
    {
        return $this->operator;
    }

    public function getSuboperator(): ?BusinessDetails
    {
        return $this->suboperator;
    }

    public function getOwner(): ?BusinessDetails
    {
        return $this->owner;
    }

    /**
     * @return Facility[]|null
     */
    public function getFacilities(): ?array
    {
        return $this->facilities;
    }

    public function getTimeZone(): ?string
    {
        return $this->timeZone;
    }

    public function getOpeningTimes(): ?Hours
    {
        return $this->openingTimes;
    }

    public function getChargingWhenClosed(): ?bool
    {
        return $this->chargingWhenClosed;
    }

    /**
     * @return Image[]|null
     */
    public function getImages(): ?array
    {
        return $this->images;
    }

    public function getEnergyMix(): ?EnergyMix
    {
        return $this->energyMix;
    }

    public function getLastUpdated(): ?DateTime
    {
        return $this->lastUpdated;
    }

    public function jsonSerialize(): array
    {
        $return = [];

        if ($this->id !== null) {
            $return['id'] = $this->id;
        }
        if ($this->locationType !== null) {
            $return['type'] = $this->locationType;
        }
        if ($this->address !== null) {
            $return['address'] = $this->address;
        }
        if ($this->city !== null) {
            $return['city'] = $this->city;
        }
        if ($this->postalCode !== null) {
            $return['postal_code'] = $this->postalCode;
        }
        if ($this->country !== null) {
            $return['country'] = $this->country;
        }
        if ($this->coordinates !== null) {
            $return['coordinates'] = $this->coordinates;
        }
        if ($this->relatedLocations !== null) {
            $return['related_locations'] = $this->relatedLocations;
        }
        if ($this->evses !== null) {
            $return['evses'] = $this->evses;
        }
        if ($this->directions !== null) {
            $return['directions'] = $this->directions;
        }
        if ($this->facilities !== null) {
            $return['facilities'] = $this->facilities;
        }
        if ($this->images !== null) {
            $return['images'] = $this->images;
        }
        if ($this->lastUpdated !== null) {
            $return['last_updated'] = DateTimeFormatter::format($this->lastUpdated);
        }
        if ($this->name !== null) {
            $return['name'] = $this->name;
        }
        if ($this->operator !== null) {
            $return['operator'] = $this->operator;
        }
        if ($this->suboperator !== null) {
            $return['suboperator'] = $this->suboperator;
        }
        if ($this->owner !== null) {
            $return['owner'] = $this->owner;
        }
        if ($this->timeZone !== null) {
            $return['time_zone'] = $this->timeZone;
        }
        if ($this->openingTimes !== null) {
            $return['opening_times'] = $this->openingTimes;
        }
        if ($this->chargingWhenClosed !== null) {
            $return['charging_when_closed'] = $this->chargingWhenClosed;
        }
        if ($this->energyMix !== null) {
            $return['energy_mix'] = $this->energyMix;
        }

        return $return;
    }
}


