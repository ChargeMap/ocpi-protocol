<?php


namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use DateTime;
use JsonSerializable;

class PartialEVSE implements JsonSerializable
{
    private ?string $uid;

    private ?string $evseId;

    private ?EVSEStatus $status;

    /** @var StatusSchedule[]|null */
    private ?array $statusSchedule;

    /** @var Capability[]|null */
    private ?array $capabilities;

    /** @var Connector[]|null */
    private ?array $connectors;

    private ?string $floorLevel;

    private ?GeoLocation $coordinates;

    private ?string $physicalReference;

    /** @var DisplayText[]|null */
    private ?array $directions;

    /** @var ParkingRestriction[]|null */
    private ?array $parkingRestrictions;

    /** @var Image[]|null */
    private ?array $images;

    private ?DateTime $lastUpdated;

    public function __construct(?string $uid, ?string $evseId, ?EVSEStatus $status, ?string $floorLevel, ?GeoLocation $coordinates, ?string $physicalReference, ?DateTime $lastUpdated)
    {
        $this->uid = $uid;
        $this->evseId = $evseId;
        $this->status = $status;
        $this->floorLevel = $floorLevel;
        $this->coordinates = $coordinates;
        $this->physicalReference = $physicalReference;
        $this->lastUpdated = $lastUpdated;
    }

    public function addStatusSchedule(StatusSchedule $schedule): self
    {
        $this->statusSchedule[] = $schedule;

        return $this;
    }

    public function addCapability(Capability $capability): self
    {
        $this->capabilities[] = $capability;

        return $this;
    }

    public function addConnector(Connector $connector): self
    {
        $this->connectors[] = $connector;

        return $this;
    }

    public function addDirection(DisplayText $direction): self
    {
        $this->directions[] = $direction;

        return $this;
    }

    public function addParkingRestriction(ParkingRestriction $parkingRestriction): self
    {
        $this->parkingRestrictions[] = $parkingRestriction;

        return $this;
    }

    public function addImage(Image $image): self
    {
        $this->images[] = $image;

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
     * @return StatusSchedule[]
     */
    public function getStatusSchedule(): array
    {
        return $this->statusSchedule;
    }

    /**
     * @return Capability[]
     */
    public function getCapabilities(): array
    {
        return $this->capabilities;
    }

    /**
     * @return Connector[]
     */
    public function getConnectors(): array
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
     * @return DisplayText[]
     */
    public function getDirections(): array
    {
        return $this->directions;
    }

    /**
     * @return ParkingRestriction[]
     */
    public function getParkingRestrictions(): array
    {
        return $this->parkingRestrictions;
    }

    /**
     * @return Image[]
     */
    public function getImages(): array
    {
        return $this->images;
    }

    public function getLastUpdated(): DateTime
    {
        return $this->lastUpdated;
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
            $return['last_updated'] = $this->lastUpdated->format(DateTime::ISO8601);
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
