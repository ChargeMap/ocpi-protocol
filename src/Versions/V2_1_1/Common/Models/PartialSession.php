<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use DateTime;
use JsonSerializable;

class PartialSession implements JsonSerializable
{
    private bool $hasStartDate;
    private bool $hasEndDate;
    private bool $hasKwh;
    private bool $hasAuthId;
    private bool $hasAuthMethod;
    private bool $hasLocation;
    private bool $hasMeterId;
    private bool $hasCurrency;
    private bool $hasChargingPeriods;
    private bool $hasTotalCost;
    private bool $hasStatus;
    private bool $hasLastUpdated;

    private string $id;
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

    public function __construct(string $id)
    {
        $this->id = $id;
        $this->hasStartDate = false;
        $this->hasEndDate = false;
        $this->hasKwh = false;
        $this->hasAuthId = false;
        $this->hasAuthMethod = false;
        $this->hasLocation = false;
        $this->hasMeterId = false;
        $this->hasCurrency = false;
        $this->hasChargingPeriods = false;
        $this->hasTotalCost = false;
        $this->hasStatus = false;
        $this->hasLastUpdated = false;
    }

    public function setStartDate(DateTime $startDate): void
    {
        $this->hasStartDate = true;
        $this->startDate = $startDate;
    }

    public function setEndDate(?DateTime $endDate): void
    {
        $this->hasEndDate = true;
        $this->endDate = $endDate;
    }

    public function setKwh(float $kwh): void
    {
        $this->hasKwh = true;
        $this->kwh = $kwh;
    }

    public function setAuthId(string $authId): void
    {
        $this->hasAuthId = true;
        $this->authId = $authId;
    }

    public function setAuthMethod(AuthenticationMethod $authMethod): void
    {
        $this->hasAuthMethod = true;
        $this->authMethod = $authMethod;
    }

    public function setLocation(Location $location): void
    {
        $this->hasLocation = true;
        $this->location = $location;
    }

    public function setMeterId(?string $meterId): void
    {
        $this->hasMeterId = true;
        $this->meterId = $meterId;
    }

    public function setCurrency(string $currency): void
    {
        $this->hasCurrency = true;
        $this->currency = $currency;
    }

    public function setEmptyChargingPeriod(): void
    {
        $this->hasChargingPeriods = true;
    }

    public function addChargingPeriod(ChargingPeriod $period): self
    {
        $this->chargingPeriods[] = $period;
        return $this;
    }

    public function setTotalCost(?float $totalCost): void
    {
        $this->hasTotalCost = true;
        $this->totalCost = $totalCost;
    }

    public function setStatus(SessionStatus $status): void
    {
        $this->hasStatus = true;
        $this->status = $status;
    }

    public function setLastUpdated(DateTime $lastUpdated): void
    {
        $this->hasLastUpdated = true;
        $this->lastUpdated = $lastUpdated;
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

    public function hasStartDate(): bool
    {
        return $this->hasStartDate;
    }

    public function hasEndDate(): bool
    {
        return $this->hasEndDate;
    }

    public function hasKwh(): bool
    {
        return $this->hasKwh;
    }

    public function hasAuthId(): bool
    {
        return $this->hasAuthId;
    }

    public function hasAuthMethod(): bool
    {
        return $this->hasAuthMethod;
    }

    public function hasLocation(): bool
    {
        return $this->hasLocation;
    }

    public function hasMeterId(): bool
    {
        return $this->hasMeterId;
    }

    public function hasCurrency(): bool
    {
        return $this->hasCurrency;
    }

    public function hasChargingPeriods(): bool
    {
        return $this->hasChargingPeriods;
    }

    public function hasTotalCost(): bool
    {
        return $this->hasTotalCost;
    }

    public function hasStatus(): bool
    {
        return $this->hasStatus;
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
        if ($this->startDate !== null) {
            $return['start_datetime'] = DateTimeFormatter::format($this->startDate);
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
            $return['last_updated'] = DateTimeFormatter::format($this->lastUpdated);
        }
        if ($this->meterId !== null) {
            $return['meter_id'] = $this->meterId;
        }
        if ($this->totalCost !== null) {
            $return['total_cost'] = $this->totalCost;
        }
        if ($this->endDate !== null) {
            $return['end_datetime'] = DateTimeFormatter::format($this->endDate);
        }
        return $return;
    }
}
