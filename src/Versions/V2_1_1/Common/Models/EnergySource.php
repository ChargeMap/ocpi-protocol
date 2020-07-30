<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use JsonSerializable;

class EnergySource implements JsonSerializable
{
    private EnergySourceCategory $source;

    private float $percentage;

    public function __construct(EnergySourceCategory $source, float $percentage)
    {
        $this->source = $source;
        $this->percentage = $percentage;
    }

    public function jsonSerialize()
    {
        return [
            'source' => $this->source,
            'percentage' => $this->percentage,
        ];
    }
}
