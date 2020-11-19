<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use JsonSerializable;

class EnergySource implements JsonSerializable
{
    private EnergySourceCategory $source;

    private int $percentage;

    public function __construct(EnergySourceCategory $source, int $percentage)
    {
        $this->source = $source;
        $this->percentage = $percentage;
    }

    public function getSource(): EnergySourceCategory
    {
        return $this->source;
    }

    public function getPercentage(): int
    {
        return $this->percentage;
    }

    public function jsonSerialize(): array
    {
        return [
            'source' => $this->source,
            'percentage' => $this->percentage,
        ];
    }
}
