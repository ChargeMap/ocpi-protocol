<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use JsonSerializable;

class Hours implements JsonSerializable
{
    /** @var RegularHours[] */
    private array $regularHours = [];

    private bool $twentyForSeven;

    /** @var ExceptionalPeriod[] */
    private array $exceptionalOpenings = [];

    /** @var ExceptionalPeriod[] */
    private array $exceptionalClosings = [];

    public function __construct(bool $twentyForSeven)
    {
        $this->twentyForSeven = $twentyForSeven;
    }

    public function addHours(RegularHours $hours): self
    {
        if (!$this->twentyForSeven) {
            $this->regularHours[] = $hours;
        }

        return $this;
    }

    public function addExceptionalOpening(ExceptionalPeriod $exceptionalPeriod): self
    {
        $this->exceptionalOpenings[] = $exceptionalPeriod;
        return $this;
    }

    public function addExceptionalClosing(ExceptionalPeriod $exceptionalPeriod): self
    {
        $this->exceptionalClosings[] = $exceptionalPeriod;
        return $this;
    }

    /**
     * @return RegularHours[]
     */
    public function getRegularHours(): array
    {
        return $this->regularHours;
    }

    public function isTwentyForSeven(): bool
    {
        return $this->twentyForSeven;
    }

    /**
     * @return ExceptionalPeriod[]
     */
    public function getExceptionalOpenings(): array
    {
        return $this->exceptionalOpenings;
    }

    /**
     * @return ExceptionalPeriod[]
     */
    public function getExceptionalClosings(): array
    {
        return $this->exceptionalClosings;
    }

    public function jsonSerialize()
    {
        $return = [
            'exceptional_openings' => $this->exceptionalOpenings,
            'exceptional_closings' => $this->exceptionalClosings
        ];

        if ($this->twentyForSeven) {
            $return['twentyforseven'] = $this->twentyForSeven;
        } else {
            $return['regular_hours'] = $this->regularHours;
        }

        return $return;
    }
}
