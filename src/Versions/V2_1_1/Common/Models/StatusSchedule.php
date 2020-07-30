<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use DateTime;
use JsonSerializable;

class StatusSchedule implements JsonSerializable
{
    private DateTime $periodBegin;

    private DateTime $periodEnd;

    private EVSEStatus $status;

    public function __construct(DateTime $periodBegin, DateTime $periodEnd, EVSEStatus $status)
    {
        $this->periodBegin = $periodBegin;
        $this->periodEnd = $periodEnd;
        $this->status = $status;
    }

    public function getPeriodBegin(): DateTime
    {
        return $this->periodBegin;
    }

    public function getPeriodEnd(): DateTime
    {
        return $this->periodEnd;
    }

    public function getStatus(): EVSEStatus
    {
        return $this->status;
    }

    public function jsonSerialize()
    {
        return [
            'period_begin' => $this->periodBegin->format(DateTime::ISO8601),
            'period_end' => $this->periodEnd->format(DateTime::ISO8601),
            'status' => $this->status,
        ];
    }
}
