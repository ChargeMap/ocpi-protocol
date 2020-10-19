<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use DateTime;
use JsonSerializable;

class Session implements JsonSerializable
{
    private string $id;

    private DateTime $startDate;

    private ?DateTime $endDate;

    private float $kwh;

    private string $authId;

    private AuthenticationMethod $authMethod;

    private Location $location;

    private ?string $meterId;

    private string $currency;

    /** @var ChargingPeriod[] */
    private array $chargingPeriods = [];

    private ?float $totalCost;

    private SessionStatus $status;

    private DateTime $lastUpdated;

    public function __construct(string $id, DateTime $startDate, ?DateTime $endDate, float $kwh, string $authId, AuthenticationMethod $authMethod, Location $location, ?string $meterId, string $currency, ?float $totalCost, SessionStatus $status, DateTime $lastUpdated)
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

    public function addChargingPeriod(ChargingPeriod $period): void
    {
        $this->chargingPeriods[] = $period;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    public function getEndDate(): ?DateTime
    {
        return $this->endDate;
    }

    public function getKwh(): float
    {
        return $this->kwh;
    }

    public function getAuthId(): string
    {
        return $this->authId;
    }

    public function getAuthMethod(): AuthenticationMethod
    {
        return $this->authMethod;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getMeterId(): ?string
    {
        return $this->meterId;
    }

    public function getChargingPeriods(): array
    {
        return $this->chargingPeriods;
    }

    public function getTotalCost(): ?float
    {
        return $this->totalCost;
    }

    public function getStatus(): SessionStatus
    {
        return $this->status;
    }

    public function getLastUpdated(): DateTime
    {
        return $this->lastUpdated;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'id' => $this->id,
            'start_datetime' => DateTimeFormatter::format($this->startDate),
            'kwh' => $this->kwh,
            'auth_id' => $this->authId,
            'auth_method' => $this->authMethod,
            'location' => $this->location,
            'currency' => $this->currency,
            'charging_periods' => $this->chargingPeriods,
            'status' => $this->status,
            'last_updated' => DateTimeFormatter::format($this->lastUpdated)
        ];

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
