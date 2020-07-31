<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use DateTime;
use JsonSerializable;

class Location implements JsonSerializable
{
    private string $id;

    private LocationType $locationType;

    private ?string $name;

    private string $address;

    private string $city;

    private string $postalCode;

    private string $country;

    private GeoLocation $coordinates;

    /** @var AdditionalGeoLocation[] */
    private array $relatedLocations = [];

    /** @var EVSE[] */
    private array $evses = [];

    /** @var DisplayText[] */
    private array $directions = [];

    private ?BusinessDetails $operator;

    private ?BusinessDetails $suboperator;

    private ?BusinessDetails $owner;

    /** @var Facility[] */
    private array $facilities = [];

    private ?string $timeZone;

    private ?Hours $openingTimes;

    private ?bool $chargingWhenClosed;

    /** @var Image[] */
    private array $images = [];

    private ?EnergyMix $energyMix;

    private DateTime $lastUpdated;

    public function __construct(
        string $id,
        LocationType $locationType,
        ?string $name,
        string $address,
        string $city,
        string $postalCode,
        string $country,
        GeoLocation $coordinates,
        ?BusinessDetails $operator,
        ?BusinessDetails $suboperator,
        ?BusinessDetails $owner,
        ?string $timeZone,
        ?Hours $openingTimes,
        ?bool $chargingWhenClosed,
        ?EnergyMix $energyMix,
        DateTime $lastUpdated
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

    public function getId(): string
    {
        return $this->id;
    }

    public function getLocationType(): LocationType
    {
        return $this->locationType;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getCoordinates(): GeoLocation
    {
        return $this->coordinates;
    }

    /**
     * @return AdditionalGeoLocation[]
     */
    public function getRelatedLocations(): array
    {
        return $this->relatedLocations;
    }

    /**
     * @return EVSE[]
     */
    public function getEvses(): array
    {
        return $this->evses;
    }

    /**
     * @return DisplayText[]
     */
    public function getDirections(): array
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
     * @return Facility[]
     */
    public function getFacilities(): array
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
     * @return Image[]
     */
    public function getImages(): array
    {
        return $this->images;
    }

    public function getEnergyMix(): ?EnergyMix
    {
        return $this->energyMix;
    }

    public function getLastUpdated(): DateTime
    {
        return $this->lastUpdated;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'id' => $this->id,
            'type' => $this->locationType,
            'address' => $this->address,
            'city' => $this->city,
            'postal_code' => $this->postalCode,
            'country' => $this->country,
            'coordinates' => $this->coordinates,
            'related_locations' => $this->relatedLocations,
            'evses' => $this->evses,
            'directions' => $this->directions,
            'facilities' => $this->facilities,
            'images' => $this->images,
            'last_updates' => $this->lastUpdated->format(DateTime::ISO8601),
        ];

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
