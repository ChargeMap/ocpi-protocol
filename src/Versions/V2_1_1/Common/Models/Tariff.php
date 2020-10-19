<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use DateTime;
use JsonSerializable;

class Tariff implements JsonSerializable
{
    private string $id;

    private string $currency;

    /** @var DisplayText[] */
    private array $tariffAltText = [];

    private ?string $tariffAltUrl;

    /** @var TariffElement[] */
    private array $elements = [];

    private ?EnergyMix $energyMix;

    private DateTime $lastUpdated;

    public function __construct(string $id, string $currency, ?string $tariffAltUrl, ?EnergyMix $energyMix, DateTime $lastUpdated)
    {
        $this->id = $id;
        $this->currency = $currency;
        $this->tariffAltUrl = $tariffAltUrl;
        $this->energyMix = $energyMix;
        $this->lastUpdated = $lastUpdated;
    }

    public function addTariffAltText(DisplayText $text): self
    {
        $this->tariffAltText[] = $text;

        return $this;
    }

    public function addTariffElement(TariffElement $element): self
    {
        $this->elements[] = $element;

        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return DisplayText[]
     */
    public function getTariffAltText(): array
    {
        return $this->tariffAltText;
    }

    public function getTariffAltUrl(): ?string
    {
        return $this->tariffAltUrl;
    }

    /**
     * @return TariffElement[]
     */
    public function getElements(): array
    {
        return $this->elements;
    }

    public function getEnergyMix(): ?EnergyMix
    {
        return $this->energyMix;
    }

    public function getLastUpdated(): DateTime
    {
        return $this->lastUpdated;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'id' => $this->id,
            'currency' => $this->currency,
            'elements' => $this->elements,
            'last_updated' => DateTimeFormatter::format($this->lastUpdated),
        ];

        if (count($this->tariffAltText) > 0) {
            $return['tariff_alt_text'] = $this->tariffAltText;
        }

        if ($this->tariffAltUrl !== null) {
            $return['tariff_alt_url'] = $this->tariffAltUrl;
        }

        if ($this->energyMix !== null) {
            $return['energy_mix'] = $this->energyMix;
        }

        return $return;
    }
}
