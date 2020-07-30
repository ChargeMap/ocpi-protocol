<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use DateTime;
use JsonSerializable;

class ChargingPeriod implements JsonSerializable
{
    private DateTime $startDate;

    /** @var CdrDimension[] */
    private array $cdrDimensions = [];

    public function __construct(DateTime $startDate)
    {
        $this->startDate = $startDate;
    }

    public function addDimension(CdrDimension $dimension): void
    {
        $this->cdrDimensions[$dimension->getType()->getValue()] = $dimension;
    }

    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    /** @return CdrDimension[] */
    public function getCdrDimensions(): array
    {
        return $this->cdrDimensions;
    }

    public function getCdrDimension(CdrDimensionType $dimensionType): ?CdrDimension
    {
        return array_key_exists($dimensionType->getValue(), $this->cdrDimensions) ? $this->cdrDimensions[$dimensionType->getValue()] : null;
    }

    public function jsonSerialize(): array
    {
        return [
            'start_date_time' => $this->startDate->format(DateTime::ISO8601),
            'dimensions' => $this->cdrDimensions
        ];
    }
}
