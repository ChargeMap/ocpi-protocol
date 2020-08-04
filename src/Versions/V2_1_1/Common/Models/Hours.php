<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use JsonSerializable;

class Hours implements JsonSerializable
{
    /** @var RegularHours[] */
    private array $regularHours = [];

    private bool $twentyFourSeven;

    /** @var ExceptionalPeriod[] */
    private array $exceptionalOpenings = [];

    /** @var ExceptionalPeriod[] */
    private array $exceptionalClosings = [];

    public function __construct(bool $twentyFourSeven)
    {
        $this->twentyFourSeven = $twentyFourSeven;
    }

    public function addHours(RegularHours $hours): self
    {
        if (!$this->twentyFourSeven) {
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

    public function isTwentyFourSeven(): bool
    {
        return $this->twentyFourSeven;
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

        if ($this->twentyFourSeven) {
            $return['twentyfourseven'] = $this->twentyFourSeven;
        } else {
            $return['regular_hours'] = $this->regularHours;
        }

        return $return;
    }
}
