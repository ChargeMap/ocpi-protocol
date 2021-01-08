<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use DateTime;
use JsonSerializable;

class PartialEVSE implements JsonSerializable
{
    private bool $hasUid;
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

    private ?string $uid = null;
    private ?string $evseId = null;
    private ?EVSEStatus $status = null;
    /** @var StatusSchedule[]|null */
    private ?array $statusSchedule = [];
    /** @var Capability[]|null */
    private ?array $capabilities = [];
    /** @var Connector[]|null */
    private ?array $connectors = [];
    private ?string $floorLevel = null;
    private ?GeoLocation $coordinates = null;
    private ?string $physicalReference = null;
    /** @var DisplayText[]|null */
    private ?array $directions = [];
    /** @var ParkingRestriction[]|null */
    private ?array $parkingRestrictions = [];
    /** @var Image[]|null */
    private ?array $images = [];
    private ?DateTime $lastUpdated = null;

    public function __construct()
    {
        $this->hasUid = false;
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

    public function withUid(string $uid): void
    {
        $this->hasUid = true;
        $this->uid = $uid;
    }

    public function withEvseId(?string $evseId): void
    {
        $this->hasEvseId = true;
        $this->evseId = $evseId;
    }

    public function withStatus(EVSEStatus $status): void
    {
        $this->hasStatus = true;
        $this->status = $status;
    }

    public function withEmptyStatusSchedule(): void
    {
        $this->hasStatusSchedule = true;
    }

    public function withStatusSchedule(StatusSchedule $schedule): self
    {
        $this->statusSchedule[] = $schedule;
        return $this;
    }

    public function withEmptyCapability(): void
    {
        $this->hasCapabilities = true;
    }

    public function withCapability(Capability $capability): self
    {
        $this->capabilities[] = $capability;
        return $this;
    }

    public function withEmptyConnector(): void
    {
        $this->hasConnectors = true;
    }

    public function withConnector(Connector $connector): self
    {
        $this->connectors[] = $connector;
        return $this;
    }

    public function withFloorLevel(?string $floorLevel): void
    {
        $this->hasFloorLevel = true;
        $this->floorLevel = $floorLevel;
    }

    public function withCoordinates(?GeoLocation $coordinates): void
    {
        $this->hasCoordinates = true;
        $this->coordinates = $coordinates;
    }

    public function withPhysicalReference(?string $physicalReference): void
    {
        $this->hasPhysicalReference = true;
        $this->physicalReference = $physicalReference;
    }

    public function withEmptyDirection(): void
    {
        $this->hasDirections = true;
    }

    public function withDirection(DisplayText $direction): self
    {
        $this->directions[] = $direction;
        return $this;
    }

    public function withEmptyParkingRestriction(): void
    {
        $this->hasParkingRestrictions = true;
    }

    public function withParkingRestriction(ParkingRestriction $parkingRestriction): self
    {
        $this->parkingRestrictions[] = $parkingRestriction;
        return $this;
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

    public function withLastUpdated(DateTime $lastUpdated): void
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

    public function hasUid(): bool
    {
        return $this->hasUid;
    }

    public function hasEvseId(): bool
    {
        return $this->hasEvseId;
    }

    public function hasStatus(): bool
    {
        return $this->hasStatus;
    }

    public function hasStatusSchedule(): bool
    {
        return $this->hasStatusSchedule;
    }

    public function hasCapabilities(): bool
    {
        return $this->hasCapabilities;
    }

    public function hasConnectors(): bool
    {
        return $this->hasConnectors;
    }

    public function hasFloorLevel(): bool
    {
        return $this->hasFloorLevel;
    }

    public function hasCoordinates(): bool
    {
        return $this->hasCoordinates;
    }

    public function hasPhysicalReference(): bool
    {
        return $this->hasPhysicalReference;
    }

    public function hasDirections(): bool
    {
        return $this->hasDirections;
    }

    public function hasParkingRestrictions(): bool
    {
        return $this->hasParkingRestrictions;
    }

    public function hasImages(): bool
    {
        return $this->hasImages;
    }

    public function hasLastUpdated(): bool
    {
        return $this->hasLastUpdated;
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
