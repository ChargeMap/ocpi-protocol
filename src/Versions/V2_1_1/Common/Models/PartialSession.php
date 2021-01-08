<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use DateTime;
use JsonSerializable;

class PartialSession implements JsonSerializable
{
    private bool $hasId;
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

    private ?string $id = null;
    private ?DateTime $startDate = null;
    private ?DateTime $endDate = null;
    private ?float $kwh = null;
    private ?string $authId = null;
    private ?AuthenticationMethod $authMethod = null;
    private ?Location $location = null;
    private ?string $meterId = null;
    private ?string $currency = null;
    /** @var ChargingPeriod[]|null */
    private ?array $chargingPeriods = [];
    private ?float $totalCost = null;
    private ?SessionStatus $status = null;
    private ?DateTime $lastUpdated = null;

    public function __construct()
    {
        $this->hasId = false;
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

    public function withId(string $id): void
    {
        $this->hasId = true;
        $this->id = $id;
    }

    public function withStartDate(DateTime $startDate): void
    {
        $this->hasStartDate = true;
        $this->startDate = $startDate;
    }

    public function withEndDate(?DateTime $endDate): void
    {
        $this->hasEndDate = true;
        $this->endDate = $endDate;
    }

    public function withKwh(float $kwh): void
    {
        $this->hasKwh = true;
        $this->kwh = $kwh;
    }

    public function withAuthId(string $authId): void
    {
        $this->hasAuthId = true;
        $this->authId = $authId;
    }

    public function withAuthMethod(AuthenticationMethod $authMethod): void
    {
        $this->hasAuthMethod = true;
        $this->authMethod = $authMethod;
    }

    public function withLocation(Location $location): void
    {
        $this->hasLocation = true;
        $this->location = $location;
    }

    public function withMeterId(?string $meterId): void
    {
        $this->hasMeterId = true;
        $this->meterId = $meterId;
    }

    public function withCurrency(string $currency): void
    {
        $this->hasCurrency = true;
        $this->currency = $currency;
    }

    public function withEmptyChargingPeriod(): void
    {
        $this->hasChargingPeriods = true;
    }

    public function withChargingPeriod(ChargingPeriod $period): self
    {
        $this->chargingPeriods[] = $period;
        return $this;
    }

    public function withTotalCost(?float $totalCost): void
    {
        $this->hasTotalCost = true;
        $this->totalCost = $totalCost;
    }

    public function withStatus(SessionStatus $status): void
    {
        $this->hasStatus = true;
        $this->status = $status;
    }

    public function withLastUpdated(DateTime $lastUpdated): void
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

    public function hasId(): bool
    {
        return $this->hasId;
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
