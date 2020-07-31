<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use JsonSerializable;

class EnvironmentalImpact implements JsonSerializable
{
    private EnvironmentalImpactCategory $source;

    private float $amount;

    public function __construct(EnvironmentalImpactCategory $source, float $amount)
    {
        $this->source = $source;
        $this->amount = $amount;
    }

    public function getSource(): EnvironmentalImpactCategory
    {
        return $this->source;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function jsonSerialize(): array
    {
        return [
            'source' => $this->source,
            'amount' => $this->amount,
        ];
    }
}

