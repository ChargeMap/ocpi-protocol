<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
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

    public function jsonSerialize(): array
    {
        return [
            'period_begin' => DateTimeFormatter::format($this->periodBegin),
            'period_end' => DateTimeFormatter::format($this->periodEnd),
        ];
    }
}
