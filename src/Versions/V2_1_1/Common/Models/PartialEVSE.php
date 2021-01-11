<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use Chargemap\OCPI\Common\Utils\PartialModel;
use DateTime;
use JsonSerializable;

/**
 * @method bool hasUid()
 * @method bool hasEvseId()
 * @method bool hasStatus()
 * @method bool hasStatusSchedules()
 * @method bool hasCapabilities()
 * @method bool hasConnectors()
 * @method bool hasFloorLevel()
 * @method bool hasCoordinates()
 * @method bool hasPhysicalReference()
 * @method bool hasDirections()
 * @method bool hasParkingRestrictions()
 * @method bool hasImages()
 * @method bool hasLastUpdated()
 * @method self withUid(string $uid)
 * @method self withEvseId(?string $evseId)
 * @method self withStatus(EVSEStatus $status)
 * @method self withStatusSchedules()
 * @method self withCapabilities()
 * @method self withConnectors()
 * @method self withFloorLevel(?string $floorLevel)
 * @method self withCoordinates(?GeoLocation $coordinates)
 * @method self withPhysicalReference(?string $physicalReference)
 * @method self withDirections()
 * @method self withParkingRestrictions()
 * @method self withImages()
 * @method self withLastUpdated(DateTime $lastUpdated)
 */
class PartialEVSE extends PartialModel implements JsonSerializable
{
    private ?string $uid = null;
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
    private ?array $directions = [];
    /** @var ParkingRestriction[]|null */
    private ?array $parkingRestrictions = null;
    /** @var Image[]|null */
    private ?array $images = [];
    private ?DateTime $lastUpdated = null;

    protected function _withUid(string $uid): self
    {
        $this->uid = $uid;
        return $this;
    }

    protected function _withEvseId(?string $evseId): self
    {
        $this->evseId = $evseId;
        return $this;
    }

    protected function _withStatus(EVSEStatus $status): self
    {
        $this->status = $status;
        return $this;
    }

    protected function _withStatusSchedules(): self
    {
        $this->statusSchedule = [];
        return $this;
    }

    public function withStatusSchedule(StatusSchedule $schedule): self
    {
        $this->statusSchedule[] = $schedule;
        return $this;
    }

    protected function _withCapabilities(): self
    {
        $this->capabilities = [];
        return $this;
    }

    public function withCapability(Capability $capability): self
    {
        $this->capabilities[] = $capability;
        return $this;
    }

    protected function _withConnectors(): self
    {
        $this->connectors = [];
        return $this;
    }

    public function withConnector(Connector $connector): self
    {
        $this->connectors[] = $connector;
        return $this;
    }

    protected function _withFloorLevel(?string $floorLevel): self
    {
        $this->floorLevel = $floorLevel;
        return $this;
    }

    protected function _withCoordinates(?GeoLocation $coordinates): self
    {
        $this->coordinates = $coordinates;
        return $this;
    }

    protected function _withPhysicalReference(?string $physicalReference): self
    {
        $this->physicalReference = $physicalReference;
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

    protected function _withParkingRestrictions(): self
    {
        $this->parkingRestrictions = [];
        return $this;
    }

    public function withParkingRestriction(ParkingRestriction $parkingRestriction): self
    {
        $this->parkingRestrictions[] = $parkingRestriction;
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

    protected function _withLastUpdated(DateTime $lastUpdated): self
    {
        $this->lastUpdated = $lastUpdated;
        return $this;
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

    public function jsonSerialize(): array
    {
        $return = [];
        if ($this->hasUid()) {
            $return['uid'] = $this->uid;
        }
        if ($this->hasStatus()) {
            $return['status'] = $this->status;
        }
        if ($this->hasStatusSchedules()) {
            $return['status_schedule'] = $this->statusSchedule;
        }
        if ($this->hasCapabilities()) {
            $return['capabilities'] = $this->capabilities;
        }
        if ($this->hasConnectors()) {
            $return['connectors'] = $this->connectors;
        }
        if ($this->hasDirections()) {
            $return['directions'] = $this->directions;
        }
        if ($this->hasParkingRestrictions()) {
            $return['parking_restrictions'] = $this->parkingRestrictions;
        }
        if ($this->hasImages()) {
            $return['images'] = $this->images;
        }
        if ($this->hasLastUpdated()) {
            $return['last_updated'] = DateTimeFormatter::format($this->lastUpdated);
        }
        if ($this->hasEvseId()) {
            $return['evse_id'] = $this->evseId;
        }
        if ($this->hasFloorLevel()) {
            $return['floor_level'] = $this->floorLevel;
        }
        if ($this->hasCoordinates()) {
            $return['coordinates'] = $this->coordinates;
        }
        if ($this->hasPhysicalReference()) {
            $return['physical_reference'] = $this->physicalReference;
        }

        return $return;
    }
}
