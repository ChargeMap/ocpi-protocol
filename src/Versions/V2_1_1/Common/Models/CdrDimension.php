<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use JsonSerializable;

class CdrDimension implements JsonSerializable
{
    private CdrDimensionType $type;

    private float $volume;

    public function __construct(CdrDimensionType $type, float $volume)
    {
        $this->type = $type;
        $this->volume = $volume;
    }

    public function getType(): CdrDimensionType
    {
        return $this->type;
    }

    public function getVolume(): float
    {
        return $this->volume;
    }

    public function jsonSerialize(): array
    {
        return [
            'type' => $this->type,
            'volume' => $this->volume
        ];
    }
}
