<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use JsonSerializable;

class PriceComponent implements JsonSerializable
{
    private TariffDimensionType $type;

    private float $price;

    private int $stepSize;

    public function __construct(TariffDimensionType $type, float $price, int $stepSize)
    {
        $this->type = $type;
        $this->price = $price;
        $this->stepSize = $stepSize;
    }

    public function getType(): TariffDimensionType
    {
        return $this->type;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getStepSize(): int
    {
        return $this->stepSize;
    }

    public function jsonSerialize(): array
    {
        return [
            'type' => $this->type,
            'price' => $this->price,
            'step_size' => $this->stepSize
        ];
    }
}