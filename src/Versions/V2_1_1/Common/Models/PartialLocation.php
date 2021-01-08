<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use DateTime;
use JsonSerializable;

class PartialLocation implements JsonSerializable
{
    private bool $hasId;
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

    private ?string $id = null;
    private ?LocationType $locationType = null;
    private ?string $name = null;
    private ?string $address = null;
    private ?string $city = null;
    private ?string $postalCode = null;
    private ?string $country = null;
    private ?GeoLocation $coordinates = null;
    /** @var AdditionalGeoLocation[]|null */
    private ?array $relatedLocations = [];
    /** @var EVSE[]|null */
    private ?array $evses = [];
    /** @var DisplayText[]|null */
    private ?array $directions = [];
    private ?BusinessDetails $operator = null;
    private ?BusinessDetails $suboperator = null;
    private ?BusinessDetails $owner = null;
    /** @var Facility[]|null */
    private ?array $facilities = [];
    private ?string $timeZone = null;
    private ?Hours $openingTimes = null;
    private ?bool $chargingWhenClosed = null;
    /** @var Image[]|null */
    private ?array $images = [];
    private ?EnergyMix $energyMix = null;
    private ?DateTime $lastUpdated = null;

    public function __construct()
    {
        $this->hasId = false;
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

    public function withId(string $id){
        $this->hasId = true;
        $this->id = $id;
    }

    public function withLocationType(LocationType $locationType): void
    {
        $this->hasLocationType = true;
        $this->locationType = $locationType;
    }

    public function withName(?string $name): void
    {
        $this->hasName = true;
        $this->name = $name;
    }

    public function withAddress(string $address): void
    {
        $this->hasAddress = true;
        $this->address = $address;
    }

    public function withCity(string $city): void
    {
        $this->hasCity = true;
        $this->city = $city;
    }

    public function withPostalCode(string $postalCode): void
    {
        $this->hasPostalCode = true;
        $this->postalCode = $postalCode;
    }

    public function withCountry(string $country): void
    {
        $this->hasCountry = true;
        $this->country = $country;
    }

    public function withCoordinates(GeoLocation $coordinates): void
    {
        $this->hasCoordinates = true;
        $this->coordinates = $coordinates;
    }

    public function withEmptyRelatedLocation(): void
    {
        $this->hasRelatedLocations = true;
    }

    public function withRelatedLocation(AdditionalGeoLocation $relatedLocation): self
    {
        $this->relatedLocations[] = $relatedLocation;
        return $this;
    }

    public function withEmptyEvse(): void
    {
        $this->hasEvses = true;
    }

    public function withEVSE(EVSE $evse): self
    {
        $this->evses[] = $evse;
        return $this;
    }

    public function withEmptyDirection() : void
    {
        $this->hasDirections = true;
    }

    public function withDirection(DisplayText $direction): self
    {
        $this->directions[] = $direction;
        return $this;
    }

    public function withOperator(?BusinessDetails $operator): void
    {
        $this->hasOperator = true;
        $this->operator = $operator;
    }

    public function withSuboperator(?BusinessDetails $suboperator): void
    {
        $this->hasSuboperator = true;
        $this->suboperator = $suboperator;
    }

    public function withOwner(?BusinessDetails $owner): void
    {
        $this->hasOwner = true;
        $this->owner = $owner;
    }

    public function withEmptyFacility(): void
    {
        $this->hasFacilities = true;
    }

    public function withFacility(Facility $facility): self
    {
        $this->facilities[] = $facility;
        return $this;
    }

    public function withTimeZone(?string $timeZone): void
    {
        $this->hasTimeZone = true;
        $this->timeZone = $timeZone;
    }

    public function withOpeningTimes(?Hours $openingTimes): void
    {
        $this->hasOpeningTimes = true;
        $this->openingTimes = $openingTimes;
    }

    public function withChargingWhenClosed(?bool $chargingWhenClosed): void
    {
        $this->hasChargingWhenClosing = true;
        $this->chargingWhenClosed = $chargingWhenClosed;
    }

    public function withEmptyImage(): void
    {
        $this->hasImages = true;
    }

    public function withImage(Image $image): self
    {
        $this->images[] = $image;
        return $this;
    }

    public function withEnergyMix(?EnergyMix $energyMix): void
    {
        $this->hasEnergyMix = true;
        $this->energyMix = $energyMix;
    }

    public function withLastUpdated(?DateTime $lastUpdated): void
    {
        $this->hasLastUpdated = true;
        $this->lastUpdated = $lastUpdated;
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

    public function hasId(): bool
    {
        return $this->hasId;
    }

    public function hasLocationType(): bool
    {
        return $this->hasLocationType;
    }

    public function hasName(): bool
    {
        return $this->hasName;
    }

    public function hasAddress(): bool
    {
        return $this->hasAddress;
    }

    public function hasCity(): bool
    {
        return $this->hasCity;
    }

    public function hasPostalCode(): bool
    {
        return $this->hasPostalCode;
    }

    public function hasCountry(): bool
    {
        return $this->hasCountry;
    }

    public function hasCoordinates(): bool
    {
        return $this->hasCoordinates;
    }

    public function hasRelatedLocations(): bool
    {
        return $this->hasRelatedLocations;
    }

    public function hasEvses(): bool
    {
        return $this->hasEvses;
    }

    public function hasDirections(): bool
    {
        return $this->hasDirections;
    }

    public function hasOperator(): bool
    {
        return $this->hasOperator;
    }

    public function hasSuboperator(): bool
    {
        return $this->hasSuboperator;
    }

    public function hasOwner(): bool
    {
        return $this->hasOwner;
    }

    public function hasFacilities(): bool
    {
        return $this->hasFacilities;
    }

    public function hasTimeZone(): bool
    {
        return $this->hasTimeZone;
    }

    public function hasOpeningTimes(): bool
    {
        return $this->hasOpeningTimes;
    }

    public function hasChargingWhenClosing(): bool
    {
        return $this->hasChargingWhenClosing;
    }

    public function hasImages(): bool
    {
        return $this->hasImages;
    }

    public function hasEnergyMix(): bool
    {
        return $this->hasEnergyMix;
    }

    public function hasLastUpdated(): bool
    {
        return $this->hasLastUpdated;
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


