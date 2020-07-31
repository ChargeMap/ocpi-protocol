<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use DateTime;
use JsonSerializable;

class ExceptionalPeriod implements JsonSerializable
{
    private DateTime $periodBegin;

    private DateTime $periodEnd;

    public function __construct(DateTime $periodBegin, DateTime $periodEnd)
    {
        $this->periodBegin = $periodBegin;
        $this->periodEnd = $periodEnd;
    }

    public function getPeriodBegin(): DateTime
    {
        return $this->periodBegin;
    }

    public function getPeriodEnd(): DateTime
    {
        return $this->periodEnd;
    }

    public function jsonSerialize()
    {
        return [
            'period_begin' => $this->periodBegin->format(DateTime::ISO8601),
            'period_end' => $this->periodEnd->format(DateTime::ISO8601),
        ];
    }
}
