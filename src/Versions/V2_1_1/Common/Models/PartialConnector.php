<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use DateTime;
use JsonSerializable;

class PartialConnector implements JsonSerializable
{
    private bool $hasStandard;
    private bool $hasFormat;
    private bool $hasPowerType;
    private bool $hasVoltage;
    private bool $hasAmperage;
    private bool $hasTariffId;
    private bool $hasTermsAndConditions;
    private bool $hasLastUpdated;

    private string $id;
    private ?ConnectorType $standard = null;
    private ?ConnectorFormat $format = null;
    private ?PowerType $powerType = null;
    private ?int $voltage = null;
    private ?int $amperage = null;
    private ?string $tariffId = null;
    private ?string $termsAndConditions = null;
    private ?DateTime $lastUpdated = null;

    public function __construct(string $id)
    {
        $this->id = $id;
        $this->hasStandard = false;
        $this->hasFormat = false;
        $this->hasPowerType = false;
        $this->hasVoltage = false;
        $this->hasAmperage = false;
        $this->hasTariffId = false;
        $this->hasTermsAndConditions = false;
        $this->hasLastUpdated = false;
    }

    public function setStandard(ConnectorType $standard): void
    {
        $this->hasStandard = true;
        $this->standard = $standard;
    }

    public function setFormat(ConnectorFormat $format): void
    {
        $this->hasFormat = true;
        $this->format = $format;
    }

    public function setPowerType(PowerType $powerType): void
    {
        $this->hasPowerType = true;
        $this->powerType = $powerType;
    }

    public function setVoltage(int $voltage): void
    {
        $this->hasVoltage = true;
        $this->voltage = $voltage;
    }

    public function setAmperage(int $amperage): void
    {
        $this->hasAmperage = true;
        $this->amperage = $amperage;
    }

    public function setTariffId(?string $tariffId): void
    {
        $this->hasTariffId = true;
        $this->tariffId = $tariffId;
    }

    public function setTermsAndConditions(?string $termsAndConditions): void
    {
        $this->hasTermsAndConditions = true;
        $this->termsAndConditions = $termsAndConditions;
    }

    public function setLastUpdated(DateTime $lastUpdated): void
    {
        $this->hasLastUpdated = true;
        $this->lastUpdated = $lastUpdated;
    }

    public function hasStandard(bool $hasStandard): void
    {
        $this->hasStandard = $hasStandard;
    }

    public function hasFormat(bool $hasFormat): void
    {
        $this->hasFormat = $hasFormat;
    }

    public function hasPowerType(bool $hasPowerType): void
    {
        $this->hasPowerType = $hasPowerType;
    }

    public function hasVoltage(bool $hasVoltage): void
    {
        $this->hasVoltage = $hasVoltage;
    }

    public function hasAmperage(bool $hasAmperage): void
    {
        $this->hasAmperage = $hasAmperage;
    }

    public function hasTariffId(bool $hasTariffId): void
    {
        $this->hasTariffId = $hasTariffId;
    }

    public function hasTermsAndConditions(bool $hasTermsAndConditions): void
    {
        $this->hasTermsAndConditions = $hasTermsAndConditions;
    }

    public function hasLastUpdated(bool $hasLastUpdated): void
    {
        $this->hasLastUpdated = $hasLastUpdated;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getStandard(): ?ConnectorType
    {
        return $this->standard;
    }

    public function getFormat(): ?ConnectorFormat
    {
        return $this->format;
    }

    public function getPowerType(): ?PowerType
    {
        return $this->powerType;
    }

    public function getVoltage(): ?int
    {
        return $this->voltage;
    }

    public function getAmperage(): ?int
    {
        return $this->amperage;
    }

    public function getTariffId(): ?string
    {
        return $this->tariffId;
    }

    public function getTermsAndConditions(): ?string
    {
        return $this->termsAndConditions;
    }

    public function getLastUpdated(): ?DateTime
    {
        return $this->lastUpdated;
    }

    public function jsonSerialize(): array
    {
        $return = [];

        if ($this->id !== null) {
            $return['id'] = $this->id;
        }
        if ($this->standard !== null) {
            $return['standard'] = $this->standard;
        }
        if ($this->format !== null) {
            $return['format'] = $this->format;
        }
        if ($this->powerType !== null) {
            $return['power_type'] = $this->powerType;
        }
        if ($this->voltage !== null) {
            $return['voltage'] = $this->voltage;
        }
        if ($this->amperage !== null) {
            $return['amperage'] = $this->amperage;
        }
        if ($this->tariffId !== null) {
            $return['tariff_id'] = $this->tariffId;
        }
        if ($this->termsAndConditions !== null) {
            $return['terms_and_conditions'] = $this->termsAndConditions;
        }
        if ($this->lastUpdated !== null) {
            $return['last_updated'] = DateTimeFormatter::format($this->lastUpdated);
        }

        return $return;
    }
}
