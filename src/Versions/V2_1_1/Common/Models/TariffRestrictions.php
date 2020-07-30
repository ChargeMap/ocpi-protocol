<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use JsonSerializable;

class TariffRestrictions implements JsonSerializable
{
    private ?string $startTime;

    private ?string $endTime;

    private ?string $startDate;

    private ?string $endDate;

    private ?float $minKwh;

    private ?float $maxKwh;

    private ?float $minPower;

    private ?float $maxPower;

    private ?int $minDuration;

    private ?int $maxDuration;

    /** @var DayOfWeek[] */
    private array $daysOfWeek = [];

    public function __construct(
        ?string $startTime,
        ?string $endTime,
        ?string $startDate,
        ?string $endDate,
        ?float $minKwh,
        ?float $maxKwh,
        ?float $minPower,
        ?float $maxPower,
        ?int $minDuration,
        ?int $maxDuration
    )
    {
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->minKwh = $minKwh;
        $this->maxKwh = $maxKwh;
        $this->minPower = $minPower;
        $this->maxPower = $maxPower;
        $this->minDuration = $minDuration;
        $this->maxDuration = $maxDuration;
    }

    public function getStartTime(): ?string
    {
        return $this->startTime;
    }

    public function getEndTime(): ?string
    {
        return $this->endTime;
    }

    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    public function getMinKwh(): ?float
    {
        return $this->minKwh;
    }

    public function getMaxKwh(): ?float
    {
        return $this->maxKwh;
    }

    public function getMinPower(): ?float
    {
        return $this->minPower;
    }

    public function getMaxPower(): ?float
    {
        return $this->maxPower;
    }

    public function getMinDuration(): ?int
    {
        return $this->minDuration;
    }

    public function getMaxDuration(): ?int
    {
        return $this->maxDuration;
    }

    /**
     * @return DayOfWeek[]
     */
    public function getDaysOfWeek(): array
    {
        return $this->daysOfWeek;
    }

    public function addDayOfWeek(DayOfWeek $dayOfWeek): self
    {
        $this->daysOfWeek[] = $dayOfWeek;

        return $this;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'day_of_week' => $this->daysOfWeek,
        ];

        if ($this->startTime !== null) {
            $return['start_time'] = $this->startTime;
        }
        if ($this->endTime !== null) {
            $return['end_time'] = $this->endTime;
        }
        if ($this->startDate !== null) {
            $return['start_date'] = $this->startDate;
        }
        if ($this->endDate !== null) {
            $return['end_date'] = $this->endDate;
        }
        if ($this->minKwh !== null) {
            $return['min_kwh'] = $this->minKwh;
        }
        if ($this->maxKwh !== null) {
            $return['max_kwh'] = $this->maxKwh;
        }
        if ($this->minPower !== null) {
            $return['min_power'] = $this->minPower;
        }
        if ($this->maxPower !== null) {
            $return['max_power'] = $this->maxPower;
        }
        if ($this->minDuration !== null) {
            $return['min_duration'] = $this->minDuration;
        }
        if ($this->maxDuration !== null) {
            $return['max_duration'] = $this->maxDuration;
        }

        return $return;
    }
}
