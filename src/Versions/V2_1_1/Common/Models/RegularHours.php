<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use JsonSerializable;

class RegularHours implements JsonSerializable
{
    private Weekday $weekday;

    private string $periodBegin;

    private string $periodEnd;

    public function __construct(Weekday $weekday, string $periodBegin, string $periodEnd)
    {
        $this->weekday = $weekday;
        $this->periodBegin = $periodBegin;
        $this->periodEnd = $periodEnd;
    }

    public function getWeekday(): Weekday
    {
        return $this->weekday;
    }

    public function getPeriodBegin(): string
    {
        return $this->periodBegin;
    }

    public function getPeriodEnd(): string
    {
        return $this->periodEnd;
    }

    public function jsonSerialize(): array
    {
        return [
            'weekday' => $this->weekday,
            'period_begin' => $this->periodBegin,
            'period_end' => $this->periodEnd,
        ];
    }
}
