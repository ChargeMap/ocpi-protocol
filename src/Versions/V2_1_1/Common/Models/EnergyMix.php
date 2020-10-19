<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use JsonSerializable;

class EnergyMix implements JsonSerializable
{
    private bool $isGreenEnergy;

    /** @var EnergySource[] */
    private array $energySources = [];

    /** @var EnvironmentalImpact[] */
    private array $environImpact = [];

    private ?string $supplierName;

    private ?string $energyProductName;

    public function __construct(bool $isGreenEnergy, ?string $supplierName, ?string $energyProductName)
    {
        $this->isGreenEnergy = $isGreenEnergy;
        $this->supplierName = $supplierName;
        $this->energyProductName = $energyProductName;
    }

    public function addEnergySource(EnergySource $energySource): self
    {
        $this->energySources[] = $energySource;
        return $this;
    }

    public function addEnvironImpact(EnvironmentalImpact $environmentalImpact): self
    {
        $this->environImpact[] = $environmentalImpact;
        return $this;
    }

    public function isGreenEnergy(): bool
    {
        return $this->isGreenEnergy;
    }

    /**
     * @return EnergySource[]
     */
    public function getEnergySources(): array
    {
        return $this->energySources;
    }

    /**
     * @return EnvironmentalImpact[]
     */
    public function getEnvironImpact(): array
    {
        return $this->environImpact;
    }

    public function getSupplierName(): ?string
    {
        return $this->supplierName;
    }

    public function getEnergyProductName(): ?string
    {
        return $this->energyProductName;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'is_green_energy' => $this->isGreenEnergy,
            'energy_sources' => $this->energySources,
            'environ_impact' => $this->environImpact,
        ];

        if ($this->supplierName !== null) {
            $return['supplier_name'] = $this->supplierName;
        }

        if ($this->energyProductName !== null) {
            $return['energy_product_name'] = $this->energyProductName;
        }

        return $return;
    }
}
