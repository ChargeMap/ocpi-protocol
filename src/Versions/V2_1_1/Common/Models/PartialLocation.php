<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use Chargemap\OCPI\Common\Utils\PartialModel;
use DateTime;
use JsonSerializable;

/**
 * @method bool hasId()
 * @method bool hasLocationType()
 * @method bool hasName()
 * @method bool hasAddress()
 * @method bool hasCity()
 * @method bool hasPostalCode()
 * @method bool hasCountry()
 * @method bool hasCoordinates()
 * @method bool hasRelatedLocations()
 * @method bool hasEvses()
 * @method bool hasDirections()
 * @method bool hasOperator()
 * @method bool hasSuboperator()
 * @method bool hasOwner()
 * @method bool hasFacilities()
 * @method bool hasTimeZone()
 * @method bool hasOpeningTimes()
 * @method bool hasChargingWhenClosed()
 * @method bool hasImages()
 * @method bool hasEnergyMix()
 * @method bool hasLastUpdated()
 * @method self withId(?string $id)
 * @method self withLocationType(?LocationType $locationType)
 * @method self withName(?string $name)
 * @method self withAddress(?string $address)
 * @method self withCity(?string $city)
 * @method self withPostalCode(?string $postalCode)
 * @method self withCountry(?string $country)
 * @method self withCoordinates(?GeoLocation $coordinates)
 * @method self withRelatedLocations()
 * @method self withEvses()
 * @method self withDirections()
 * @method self withOperator(?BusinessDetails $operator)
 * @method self withSuboperator(?BusinessDetails $suboperator)
 * @method self withOwner(?BusinessDetails $owner)
 * @method self withFacilities()
 * @method self withTimeZone(?string $timeZone)
 * @method self withOpeningTimes(?Hours $openingTimes)
 * @method self withChargingWhenClosed(?bool $chargingWhenClosed)
 * @method self withImages()
 * @method self withEnergyMix(?EnergyMix $energyMix)
 * @method self withLastUpdated(?DateTime $lastUpdated)
 */
class PartialLocation extends PartialModel implements JsonSerializable
{
    private ?string $id = null;
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

    protected function _withId(?string $id): self
    {
        $this->id = $id;
        return $this;
    }

    protected function _withLocationType(?LocationType $locationType): self
    {
        $this->locationType = $locationType;
        return $this;
    }

    protected function _withName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    protected function _withAddress(?string $address): self
    {
        $this->address = $address;
        return $this;
    }

    protected function _withCity(?string $city): self
    {
        $this->city = $city;
        return $this;
    }

    protected function _withPostalCode(?string $postalCode): self
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    protected function _withCountry(?string $country): self
    {
        $this->country = $country;
        return $this;
    }

    protected function _withCoordinates(?GeoLocation $coordinates): self
    {
        $this->coordinates = $coordinates;
        return $this;
    }

    protected function _withRelatedLocations(): self
    {
        $this->relatedLocations = [];
        return $this;
    }

    public function withRelatedLocation(AdditionalGeoLocation $relatedLocation): self
    {
        $this->relatedLocations[] = $relatedLocation;
        return $this;
    }

    protected function _withEvses(): self
    {
        $this->evses = [];
        return $this;
    }

    public function withEvse(EVSE $evse): self
    {
        $this->evses[] = $evse;
        return $this;
    }

    protected function _withDirections(): self
    {
        $this->directions = [];
        return $this;
    }

    public function withDirection(DisplayText $direction): self
    {
        $this->directions[] = $direction;
        return $this;
    }

    protected function _withOperator(?BusinessDetails $operator): self
    {
        $this->operator = $operator;
        return $this;
    }

    protected function _withSuboperator(?BusinessDetails $suboperator): self
    {
        $this->suboperator = $suboperator;
        return $this;
    }

    protected function _withOwner(?BusinessDetails $owner): self
    {
        $this->owner = $owner;
        return $this;
    }

    protected function _withFacilities(): self
    {
        $this->facilities = [];
        return $this;
    }

    public function withFacility(Facility $facility): self
    {
        $this->facilities[] = $facility;
        return $this;
    }

    protected function _withTimeZone(?string $timeZone): self
    {
        $this->timeZone = $timeZone;
        return $this;
    }

    protected function _withOpeningTimes(?Hours $openingTimes): self
    {
        $this->openingTimes = $openingTimes;
        return $this;
    }

    protected function _withChargingWhenClosed(?bool $chargingWhenClosed): self
    {
        $this->chargingWhenClosed = $chargingWhenClosed;
        return $this;
    }

    protected function _withImages(): self
    {
        $this->images = [];
        return $this;
    }

    public function withImage(Image $image): self
    {
        $this->images[] = $image;
        return $this;
    }

    protected function _withEnergyMix(?EnergyMix $energyMix): self
    {
        $this->energyMix = $energyMix;
        return $this;
    }

    protected function _withLastUpdated(?DateTime $lastUpdated): self
    {
        $this->lastUpdated = $lastUpdated;
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

        if ($this->hasId()) {
            $return['id'] = $this->id;
        }
        if ($this->hasLocationType()) {
            $return['type'] = $this->locationType;
        }
        if ($this->hasAddress()) {
            $return['address'] = $this->address;
        }
        if ($this->hasCity()) {
            $return['city'] = $this->city;
        }
        if ($this->hasPostalCode()) {
            $return['postal_code'] = $this->postalCode;
        }
        if ($this->hasCountry()) {
            $return['country'] = $this->country;
        }
        if ($this->hasCoordinates()) {
            $return['coordinates'] = $this->coordinates;
        }
        if ($this->hasRelatedLocations()) {
            $return['related_locations'] = $this->relatedLocations;
        }
        if ($this->hasEvses()) {
            $return['evses'] = $this->evses;
        }
        if ($this->hasDirections()) {
            $return['directions'] = $this->directions;
        }
        if ($this->hasFacilities()) {
            $return['facilities'] = $this->facilities;
        }
        if ($this->hasImages()) {
            $return['images'] = $this->images;
        }
        if ($this->hasLastUpdated()) {
            $return['last_updated'] = DateTimeFormatter::format($this->lastUpdated);
        }
        if ($this->hasName()) {
            $return['name'] = $this->name;
        }
        if ($this->hasOperator()) {
            $return['operator'] = $this->operator;
        }
        if ($this->hasSuboperator()) {
            $return['suboperator'] = $this->suboperator;
        }
        if ($this->hasOwner()) {
            $return['owner'] = $this->owner;
        }
        if ($this->hasTimeZone()) {
            $return['time_zone'] = $this->timeZone;
        }
        if ($this->hasOpeningTimes()) {
            $return['opening_times'] = $this->openingTimes;
        }
        if ($this->hasChargingWhenClosed()) {
            $return['charging_when_closed'] = $this->chargingWhenClosed;
        }
        if ($this->hasEnergyMix()) {
            $return['energy_mix'] = $this->energyMix;
        }

        return $return;
    }
}


