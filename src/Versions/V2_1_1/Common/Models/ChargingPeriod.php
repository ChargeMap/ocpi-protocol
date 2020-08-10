<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
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
        $previousIndex = $this->searchCdrDimension($dimension->getType());

        if($previousIndex !== null) {
            $this->cdrDimensions[$previousIndex] = $dimension;
        } else {
            $this->cdrDimensions[] = $dimension;
        }
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
        $index = $this->searchCdrDimension($dimensionType);

        if($index === null) {
            return null;
        }

        return $this->cdrDimensions[$index];
    }

    public function jsonSerialize(): array
    {
        return [
            'start_date_time' => DateTimeFormatter::format($this->startDate),
            'dimensions' => $this->cdrDimensions
        ];
    }

    private function searchCdrDimension(CdrDimensionType $dimensionType): ?int
    {
        foreach($this->cdrDimensions as $index => $cdrDimension) {
            if($cdrDimension->getType()->equals($dimensionType)) {
                return $index;
            }
        }

        return null;
    }
}
