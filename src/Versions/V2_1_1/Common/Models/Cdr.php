<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use DateTime;
use JsonSerializable;

class Cdr implements JsonSerializable
{
    private string $id;

    private DateTime $startDateTime;

    private DateTime $stopDateTime;

    private string $authId;

    private AuthenticationMethod $authMethod;

    private Location $location;

    private ?string $meterId;

    private string $currency;

    /** @var Tariff[] */
    private array $tariffs = [];

    /** @var ChargingPeriod[] */
    private array $chargingPeriods = [];

    private float $totalCost;

    private float $totalEnergy;

    private float $totalTime;

    private ?float $totalParkingTime;

    private ?string $remark;

    private DateTime $lastUpdated;

    public function __construct(
        string $id,
        DateTime $startDateTime,
        DateTime $stopDateTime,
        string $authId,
        AuthenticationMethod $authMethod,
        Location $location,
        ?string $meterId,
        string $currency,
        float $totalCost,
        float $totalEnergy,
        float $totalTime,
        ?float $totalParkingTime,
        ?string $remark,
        DateTime $lastUpdated
    )
    {
        $this->id = $id;
        $this->startDateTime = $startDateTime;
        $this->stopDateTime = $stopDateTime;
        $this->authId = $authId;
        $this->authMethod = $authMethod;
        $this->location = $location;
        $this->meterId = $meterId;
        $this->currency = $currency;
        $this->totalCost = $totalCost;
        $this->totalEnergy = $totalEnergy;
        $this->totalTime = $totalTime;
        $this->totalParkingTime = $totalParkingTime;
        $this->remark = $remark;
        $this->lastUpdated = $lastUpdated;
    }

    public function addTariff(Tariff $tariff): self
    {
        $this->tariffs[] = $tariff;

        return $this;
    }

    public function addChargingPeriod(ChargingPeriod $period): self
    {
        $this->chargingPeriods[] = $period;

        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getStartDateTime(): DateTime
    {
        return $this->startDateTime;
    }

    public function getStopDateTime(): DateTime
    {
        return $this->stopDateTime;
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

    public function getMeterId(): ?string
    {
        return $this->meterId;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return Tariff[]
     */
    public function getTariffs(): array
    {
        return $this->tariffs;
    }

    /**
     * @return ChargingPeriod[]
     */
    public function getChargingPeriods(): array
    {
        return $this->chargingPeriods;
    }

    public function getTotalCost(): float
    {
        return $this->totalCost;
    }

    public function getTotalEnergy(): float
    {
        return $this->totalEnergy;
    }

    public function getTotalTime(): float
    {
        return $this->totalTime;
    }

    public function getTotalParkingTime(): ?float
    {
        return $this->totalParkingTime;
    }

    public function getRemark(): ?string
    {
        return $this->remark;
    }

    public function getLastUpdated(): DateTime
    {
        return $this->lastUpdated;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'id' => $this->id,
            'start_date_time' => $this->startDateTime->format(DateTime::ISO8601),
            'stop_date_time' => $this->stopDateTime->format(DateTime::ISO8601),
            'auth_id' => $this->authId,
            'auth_method' => $this->authMethod,
            'location' => $this->location,
            'currency' => $this->currency,
            'tariffs' => $this->tariffs,
            'charging_periods' => $this->chargingPeriods,
            'total_cost' => $this->totalCost,
            'total_energy' => $this->totalEnergy,
            'total_time' => $this->totalTime,
            'last_updated' => $this->lastUpdated->format(DateTime::ISO8601),
        ];

        if ($this->meterId !== null) {
            $return['meter_id'] = $this->meterId;
        }

        if ($this->totalParkingTime !== null) {
            $return['total_parking_time'] = $this->totalParkingTime;
        }

        if ($this->remark !== null) {
            $return['remark'] = $this->remark;
        }

        return $return;
    }
}
