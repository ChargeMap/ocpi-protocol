<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use DateTime;
use JsonSerializable;

class PartialLocation implements JsonSerializable
{
    private bool $hasLocationType;
    private bool $hasName;
    private bool $hasAddress;
    private bool $hasCity;
    private bool $hasPostalCode;
    private bool $hasCountry;
    private bool $hasCoordinates;
    private bool $hasRelatedLocations;
    private bool $hasEvses;
    private bool $hasDirections;
    private bool $hasOperator;
    private bool $hasSuboperator;
    private bool $hasOwner;
    private bool $hasFacilities;
    private bool $hasTimeZone;
    private bool $hasOpeningTimes;
    private bool $hasChargingWhenClosing;
    private bool $hasImages;
    private bool $hasEnergyMix;
    private bool $hasLastUpdated;

    private string $id;
    private ?LocationType $locationType = null;
    private ?string $name = null;
    private ?string $address = null;
    private ?string $city = null;
    private ?string $postalCode = null;
    private ?string $country = null;
    private ?GeoLocation $coordinates = null;
    /** @var AdditionalGeoLocation[]|null */
    private ?array $relatedLocations = null;
    /** @var EVSE[]|null */
    private ?array $evses = null;
    /** @var DisplayText[]|null */
    private ?array $directions = null;
    private ?BusinessDetails $operator = null;
    private ?BusinessDetails $suboperator = null;
    private ?BusinessDetails $owner = null;
    /** @var Facility[]|null */
    private ?array $facilities = null;
    private ?string $timeZone = null;
    private ?Hours $openingTimes = null;
    private ?bool $chargingWhenClosed = null;
    /** @var Image[]|null */
    private ?array $images = null;
    private ?EnergyMix $energyMix = null;
    private ?DateTime $lastUpdated = null;

    public function __construct(string $id)
    {
        $this->id = $id;
        $this->hasLocationType = false;
        $this->hasName = false;
        $this->hasAddress = false;
        $this->hasCity = false;
        $this->hasPostalCode = false;
        $this->hasCountry = false;
        $this->hasCoordinates = false;
        $this->hasRelatedLocations = false;
        $this->hasEvses = false;
        $this->hasDirections = false;
        $this->hasOperator = false;
        $this->hasSuboperator = false;
        $this->hasOwner = false;
        $this->hasFacilities = false;
        $this->hasTimeZone = false;
        $this->hasOpeningTimes = false;
        $this->hasChargingWhenClosing = false;
        $this->hasImages = false;
        $this->hasEnergyMix = false;
        $this->hasLastUpdated = false;
    }

    public function setLocationType(?LocationType $locationType): void
    {
        $this->hasLocationType = true;
        $this->locationType = $locationType;
    }

    public function setName(?string $name): void
    {
        $this->hasName = true;
        $this->name = $name;
    }

    public function setAddress(?string $address): void
    {
        $this->hasAddress = true;
        $this->address = $address;
    }

    public function setCity(?string $city): void
    {
        $this->hasCity = true;
        $this->city = $city;
    }

    public function setPostalCode(?string $postalCode): void
    {
        $this->hasPostalCode = true;
        $this->postalCode = $postalCode;
    }

    public function setCountry(?string $country): void
    {
        $this->hasCountry = true;
        $this->country = $country;
    }

    public function setCoordinates(?GeoLocation $coordinates): void
    {
        $this->hasCoordinates = true;
        $this->coordinates = $coordinates;
    }

    public function addRelatedLocation(AdditionalGeoLocation $relatedLocation): self
    {
        $this->hasRelatedLocations = true;
        $this->relatedLocations[] = $relatedLocation;
        return $this;
    }

    public function addEVSE(EVSE $evse): self
    {
        $this->hasEvses = true;
        $this->evses[] = $evse;
        return $this;
    }

    public function addDirection(DisplayText $direction): self
    {
        $this->hasDirections = true;
        $this->directions[] = $direction;
        return $this;
    }

    public function setOperator(?BusinessDetails $operator): void
    {
        $this->hasOperator = true;
        $this->operator = $operator;
    }

    public function setSuboperator(?BusinessDetails $suboperator): void
    {
        $this->hasSuboperator = true;
        $this->suboperator = $suboperator;
    }

    public function setOwner(?BusinessDetails $owner): void
    {
        $this->hasOwner = true;
        $this->owner = $owner;
    }

    public function addFacility(Facility $facility): self
    {
        $this->hasFacilities = true;
        $this->facilities[] = $facility;
        return $this;
    }

    public function setTimeZone(?string $timeZone): void
    {
        $this->hasTimeZone = true;
        $this->timeZone = $timeZone;
    }

    public function setOpeningTimes(?Hours $openingTimes): void
    {
        $this->hasOpeningTimes = true;
        $this->openingTimes = $openingTimes;
    }

    public function setChargingWhenClosed(?bool $chargingWhenClosed): void
    {
        $this->hasChargingWhenClosing = true;
        $this->chargingWhenClosed = $chargingWhenClosed;
    }

    public function addImage(Image $image): self
    {
        $this->hasImages = true;
        $this->images[] = $image;
        return $this;
    }

    public function setEnergyMix(?EnergyMix $energyMix): void
    {
        $this->hasEnergyMix = true;
        $this->energyMix = $energyMix;
    }

    public function setLastUpdated(?DateTime $lastUpdated): void
    {
        $this->hasLastUpdated = true;
        $this->lastUpdated = $lastUpdated;
    }


    public function hasLocationType(bool $hasLocationType): void
    {
        $this->hasLocationType = $hasLocationType;
    }

    public function hasName(bool $hasName): void
    {
        $this->hasName = $hasName;
    }

    public function hasAddress(bool $hasAddress): void
    {
        $this->hasAddress = $hasAddress;
    }

    public function hasCity(bool $hasCity): void
    {
        $this->hasCity = $hasCity;
    }

    public function hasPostalCode(bool $hasPostalCode): void
    {
        $this->hasPostalCode = $hasPostalCode;
    }

    public function hasCountry(bool $hasCountry): void
    {
        $this->hasCountry = $hasCountry;
    }

    public function hasCoordinates(bool $hasCoordinates): void
    {
        $this->hasCoordinates = $hasCoordinates;
    }

    public function hasRelatedLocations(bool $hasRelatedLocations): void
    {
        $this->hasRelatedLocations = $hasRelatedLocations;
    }

    public function hasEvses(bool $hasEvses): void
    {
        $this->hasEvses = $hasEvses;
    }

    public function hasDirections(bool $hasDirections): void
    {
        $this->hasDirections = $hasDirections;
    }

    public function hasOperator(bool $hasOperator): void
    {
        $this->hasOperator = $hasOperator;
    }

    public function hasSuboperator(bool $hasSuboperator): void
    {
        $this->hasSuboperator = $hasSuboperator;
    }

    public function hasOwner(bool $hasOwner): void
    {
        $this->hasOwner = $hasOwner;
    }

    public function hasFacilities(bool $hasFacilities): void
    {
        $this->hasFacilities = $hasFacilities;
    }

    public function hasTimeZone(bool $hasTimeZone): void
    {
        $this->hasTimeZone = $hasTimeZone;
    }

    public function hasOpeningTimes(bool $hasOpeningTimes): void
    {
        $this->hasOpeningTimes = $hasOpeningTimes;
    }

    public function hasChargingWhenClosing(bool $hasChargingWhenClosing): void
    {
        $this->hasChargingWhenClosing = $hasChargingWhenClosing;
    }

    public function hasImages(bool $hasImages): void
    {
        $this->hasImages = $hasImages;
    }

    public function hasEnergyMix(bool $hasEnergyMix): void
    {
        $this->hasEnergyMix = $hasEnergyMix;
    }

    public function hasLastUpdated(bool $hasLastUpdated): void
    {
        $this->hasLastUpdated = $hasLastUpdated;
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


