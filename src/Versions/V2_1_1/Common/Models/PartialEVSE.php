<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use DateTime;
use JsonSerializable;

class PartialEVSE implements JsonSerializable
{
    private bool $hasEvseId;
    private bool $hasStatus;
    private bool $hasStatusSchedule;
    private bool $hasCapabilities;
    private bool $hasConnectors;
    private bool $hasFloorLevel;
    private bool $hasCoordinates;
    private bool $hasPhysicalReference;
    private bool $hasDirections;
    private bool $hasParkingRestrictions;
    private bool $hasImages;
    private bool $hasLastUpdated;

    private string $uid;
    private ?string $evseId = null;
    private ?EVSEStatus $status = null;
    /** @var StatusSchedule[]|null */
    private ?array $statusSchedule = null;
    /** @var Capability[]|null */
    private ?array $capabilities = null;
    /** @var Connector[]|null */
    private ?array $connectors = null;
    private ?string $floorLevel = null;
    private ?GeoLocation $coordinates = null;
    private ?string $physicalReference = null;
    /** @var DisplayText[]|null */
    private ?array $directions = null;
    /** @var ParkingRestriction[]|null */
    private ?array $parkingRestrictions = null;
    /** @var Image[]|null */
    private ?array $images = null;
    private ?DateTime $lastUpdated = null;

    public function __construct(string $uid)
    {
        $this->uid = $uid;
        $this->hasEvseId = false;
        $this->hasStatus = false;
        $this->hasStatusSchedule = false;
        $this->hasCapabilities = false;
        $this->hasConnectors = false;
        $this->hasFloorLevel = false;
        $this->hasCoordinates = false;
        $this->hasPhysicalReference = false;
        $this->hasDirections = false;
        $this->hasParkingRestrictions = false;
        $this->hasImages = false;
        $this->hasLastUpdated = false;
    }

    public function setEvseId(?string $evseId): void
    {
        $this->hasEvseId = true;
        $this->evseId = $evseId;
    }

    public function setStatus(EVSEStatus $status): void
    {
        $this->hasStatus = true;
        $this->status = $status;
    }

    public function setEmptyStatusSchedule(): void
    {
        $this->hasStatusSchedule = true;
    }

    public function addStatusSchedule(StatusSchedule $schedule): self
    {
        $this->statusSchedule[] = $schedule;
        return $this;
    }

    public function setEmptyCapability(): void
    {
        $this->hasCapabilities = true;
    }

    public function addCapability(Capability $capability): self
    {
        $this->capabilities[] = $capability;
        return $this;
    }

    public function setEmptyConnector(): void
    {
        $this->hasConnectors = true;
    }

    public function addConnector(Connector $connector): self
    {
        $this->connectors[] = $connector;
        return $this;
    }

    public function setFloorLevel(?string $floorLevel): void
    {
        $this->hasFloorLevel = true;
        $this->floorLevel = $floorLevel;
    }

    public function setCoordinates(?GeoLocation $coordinates): void
    {
        $this->hasCoordinates = true;
        $this->coordinates = $coordinates;
    }

    public function setPhysicalReference(?string $physicalReference): void
    {
        $this->hasPhysicalReference = true;
        $this->physicalReference = $physicalReference;
    }

    public function setEmptyDirection(): void
    {
        $this->hasDirections = true;
    }

    public function addDirection(DisplayText $direction): self
    {
        $this->directions[] = $direction;
        return $this;
    }

    public function setEmptyParkingRestriction(): void
    {
        $this->hasParkingRestrictions = true;
    }

    public function addParkingRestriction(ParkingRestriction $parkingRestriction): self
    {
        $this->parkingRestrictions[] = $parkingRestriction;
        return $this;
    }

    public function setEmptyImage(): void
    {
        $this->hasImages = true;
    }

    public function addImage(Image $image): self
    {
        $this->images[] = $image;
        return $this;
    }

    public function setLastUpdated(DateTime $lastUpdated): void
    {
        $this->hasLastUpdated = true;
        $this->lastUpdated = $lastUpdated;
    }

    public function getUid(): ?string
    {
        return $this->uid;
    }

    public function getEvseId(): ?string
    {
        return $this->evseId;
    }

    public function getStatus(): ?EVSEStatus
    {
        return $this->status;
    }

    /**
     * @return StatusSchedule[]|null
     */
    public function getStatusSchedule(): ?array
    {
        return $this->statusSchedule;
    }

    /**
     * @return Capability[]|null
     */
    public function getCapabilities(): ?array
    {
        return $this->capabilities;
    }

    /**
     * @return Connector[]|null
     */
    public function getConnectors(): ?array
    {
        return $this->connectors;
    }

    public function getFloorLevel(): ?string
    {
        return $this->floorLevel;
    }

    public function getCoordinates(): ?GeoLocation
    {
        return $this->coordinates;
    }

    public function getPhysicalReference(): ?string
    {
        return $this->physicalReference;
    }

    /**
     * @return DisplayText[]|null
     */
    public function getDirections(): ?array
    {
        return $this->directions;
    }

    /**
     * @return ParkingRestriction[]|null
     */
    public function getParkingRestrictions(): ?array
    {
        return $this->parkingRestrictions;
    }

    /**
     * @return Image[]|null
     */
    public function getImages(): ?array
    {
        return $this->images;
    }

    public function getLastUpdated(): ?DateTime
    {
        return $this->lastUpdated;
    }

    public function hasEvseId(bool $hasEvseId): void
    {
        $this->hasEvseId = $hasEvseId;
    }

    public function hasStatus(bool $hasStatus): void
    {
        $this->hasStatus = $hasStatus;
    }

    public function hasStatusSchedule(bool $hasStatusSchedule): void
    {
        $this->hasStatusSchedule = $hasStatusSchedule;
    }

    public function hasCapabilities(bool $hasCapabilities): void
    {
        $this->hasCapabilities = $hasCapabilities;
    }

    public function hasConnectors(bool $hasConnectors): void
    {
        $this->hasConnectors = $hasConnectors;
    }

    public function hasFloorLevel(bool $hasFloorLevel): void
    {
        $this->hasFloorLevel = $hasFloorLevel;
    }

    public function hasCoordinates(bool $hasCoordinates): void
    {
        $this->hasCoordinates = $hasCoordinates;
    }

    public function hasPhysicalReference(bool $hasPhysicalReference): void
    {
        $this->hasPhysicalReference = $hasPhysicalReference;
    }

    public function hasDirections(bool $hasDirections): void
    {
        $this->hasDirections = $hasDirections;
    }

    public function hasParkingRestrictions(bool $hasParkingRestrictions): void
    {
        $this->hasParkingRestrictions = $hasParkingRestrictions;
    }

    public function hasImages(bool $hasImages): void
    {
        $this->hasImages = $hasImages;
    }

    public function hasLastUpdated(bool $hasLastUpdated): void
    {
        $this->hasLastUpdated = $hasLastUpdated;
    }

    public function jsonSerialize(): array
    {
        $return = [];
        if ($this->uid !== null) {
            $return['uid'] = $this->uid;
        }
        if ($this->status !== null) {
            $return['status'] = $this->status;
        }
        if ($this->statusSchedule !== null) {
            $return['status_schedule'] = $this->statusSchedule;
        }
        if ($this->capabilities !== null) {
            $return['capabilities'] = $this->capabilities;
        }
        if ($this->connectors !== null) {
            $return['connectors'] = $this->connectors;
        }
        if ($this->directions !== null) {
            $return['directions'] = $this->directions;
        }
        if ($this->parkingRestrictions !== null) {
            $return['parking_restrictions'] = $this->parkingRestrictions;
        }
        if ($this->images !== null) {
            $return['images'] = $this->images;
        }
        if ($this->lastUpdated !== null) {
            $return['last_updated'] = DateTimeFormatter::format($this->lastUpdated);
        }
        if ($this->evseId !== null) {
            $return['evse_id'] = $this->evseId;
        }
        if ($this->floorLevel !== null) {
            $return['floor_level'] = $this->floorLevel;
        }
        if ($this->coordinates !== null) {
            $return['coordinates'] = $this->coordinates;
        }
        if ($this->physicalReference !== null) {
            $return['physical_reference'] = $this->physicalReference;
        }

        return $return;
    }
}
