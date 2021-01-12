<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use DateTime;
use JsonSerializable;

class StatusSchedule implements JsonSerializable
{
    private DateTime $periodBegin;

    private ?DateTime $periodEnd;

    private EVSEStatus $status;

    public function __construct(DateTime $periodBegin, ?DateTime $periodEnd, EVSEStatus $status)
    {
        $this->periodBegin = $periodBegin;
        $this->periodEnd = $periodEnd;
        $this->status = $status;
    }

    public function getPeriodBegin(): DateTime
    {
        return $this->periodBegin;
    }

    public function getPeriodEnd(): ?DateTime
    {
        return $this->periodEnd;
    }

    public function getStatus(): EVSEStatus
    {
        return $this->status;
    }

    public function jsonSerialize(): array
    {
        return [
            'period_begin' => DateTimeFormatter::format($this->periodBegin),
            'period_end' => DateTimeFormatter::format($this->periodEnd),
            'status' => $this->status,
        ];
    }
}
