<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use DateTime;
use JsonSerializable;

class PartialSession implements JsonSerializable
{
    private ?string $id;

    private ?DateTime $startDate;

    private ?DateTime $endDate;

    private ?float $kwh;

    private ?string $authId;

    private ?AuthenticationMethod $authMethod;

    private ?Location $location;

    private ?string $meterId;

    private ?string $currency;

    /** @var ChargingPeriod[]|null */
    private ?array $chargingPeriods = null;

    private ?float $totalCost;

    private ?SessionStatus $status;

    private ?DateTime $lastUpdated;

    public function __construct(
        ?string $id,
        ?DateTime $startDate,
        ?DateTime $endDate,
        ?float $kwh,
        ?string $authId,
        ?AuthenticationMethod $authMethod,
        ?Location $location,
        ?string $meterId,
        ?string $currency,
        ?float $totalCost,
        ?SessionStatus $status,
        ?DateTime $lastUpdated
    )
    {
        $this->id = $id;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->kwh = $kwh;
        $this->authId = $authId;
        $this->authMethod = $authMethod;
        $this->location = $location;
        $this->meterId = $meterId;
        $this->currency = $currency;
        $this->totalCost = $totalCost;
        $this->status = $status;
        $this->lastUpdated = $lastUpdated;
    }

    public function addChargingPeriod(ChargingPeriod $period): self
    {
        $this->chargingPeriods[] = $period;
        return $this;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getStartDate(): ?DateTime
    {
        return $this->startDate;
    }

    public function getEndDate(): ?DateTime
    {
        return $this->endDate;
    }

    public function getKwh(): ?float
    {
        return $this->kwh;
    }

    public function getAuthId(): ?string
    {
        return $this->authId;
    }

    public function getAuthMethod(): ?AuthenticationMethod
    {
        return $this->authMethod;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function getMeterId(): ?string
    {
        return $this->meterId;
    }

    public function getChargingPeriods(): ?array
    {
        return $this->chargingPeriods;
    }

    public function getTotalCost(): ?float
    {
        return $this->totalCost;
    }

    public function getStatus(): ?SessionStatus
    {
        return $this->status;
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
        if ($this->startDate !== null) {
            $return['start_datetime'] = $this->startDate->format(DateTime::ISO8601);
        }
        if ($this->kwh !== null) {
            $return['kwh'] = $this->kwh;
        }
        if ($this->authId !== null) {
            $return['auth_id'] = $this->authId;
        }
        if ($this->authMethod !== null) {
            $return['auth_method'] = $this->authMethod;
        }
        if ($this->location !== null) {
            $return['location'] = $this->location;
        }
        if ($this->currency !== null) {
            $return['currency'] = $this->currency;
        }
        if ($this->chargingPeriods !== null) {
            $return['charging_periods'] = $this->chargingPeriods;
        }
        if ($this->status !== null) {
            $return['status'] = $this->status;
        }
        if ($this->lastUpdated !== null) {
            $return['last_updated'] = $this->lastUpdated->format(DateTime::ISO8601);
        }
        if ($this->meterId !== null) {
            $return['meter_id'] = $this->meterId;
        }
        if ($this->totalCost !== null) {
            $return['total_cost'] = $this->totalCost;
        }
        if ($this->endDate !== null) {
            $return['end_datetime'] = $this->endDate->format(DateTime::ISO8601);
        }
        return $return;
    }
}
