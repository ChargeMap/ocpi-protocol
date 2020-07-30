<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use DateTime;
use JsonSerializable;

class EVSE implements JsonSerializable
{
    private string $uid;

    private ?string $evseId;

    private EVSEStatus $status;

    /** @var StatusSchedule[] */
    private array $statusSchedule = [];

    /** Capability[] */
    private array $capabilities = [];

    /** @var Connector[] */
    private array $connectors = [];

    private ?string $floorLevel;

    private ?GeoLocation $coordinates;

    private ?string $physicalReference;

    /** @var DisplayText[] */
    private array $directions;

    /** @var ParkingRestriction[] */
    private array $parkingRestrictions = [];

    /** @var Image[] */
    private array $images = [];

    private DateTime $lastUpdated;

    /**
     * EVSE constructor.
     * @param string $uid
     * @param string|null $evseId
     * @param EVSEStatus $status
     * @param string|null $floorLevel
     * @param GeoLocation|null $coordinates
     * @param string|null $physicalReference
     * @param DateTime $lastUpdated
     */
    public function __construct(string $uid, ?string $evseId, EVSEStatus $status, ?string $floorLevel, ?GeoLocation $coordinates, ?string $physicalReference, DateTime $lastUpdated)
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

    public function getUid(): string
    {
        return $this->uid;
    }

    public function getEvseId(): ?string
    {
        return $this->evseId;
    }

    public function getStatus(): EVSEStatus
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

    public function jsonSerialize()
    {
        $return = [
            'uid' => $this->uid,
            'status' => $this->status,
            'status_schedule' => $this->statusSchedule,
            'capabilities' => $this->capabilities,
            'connectors' => $this->connectors,
            'directions' => $this->directions,
            'parking_restrictions' => $this->parkingRestrictions,
            'images' => $this->images,
            'last_updated' => $this->lastUpdated->format(DateTime::ISO8601),
        ];

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
