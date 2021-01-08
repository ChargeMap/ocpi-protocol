<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use DateTime;
use JsonSerializable;

class PartialConnector implements JsonSerializable
{
    private bool $hasId;
    private bool $hasStandard;
    private bool $hasFormat;
    private bool $hasPowerType;
    private bool $hasVoltage;
    private bool $hasAmperage;
    private bool $hasTariffId;
    private bool $hasTermsAndConditions;
    private bool $hasLastUpdated;

    private ?string $id = null;
    private ?ConnectorType $standard = null;
    private ?ConnectorFormat $format = null;
    private ?PowerType $powerType = null;
    private ?int $voltage = null;
    private ?int $amperage = null;
    private ?string $tariffId = null;
    private ?string $termsAndConditions = null;
    private ?DateTime $lastUpdated = null;

    public function __construct()
    {
        $this->hasId = false;
        $this->hasStandard = false;
        $this->hasFormat = false;
        $this->hasPowerType = false;
        $this->hasVoltage = false;
        $this->hasAmperage = false;
        $this->hasTariffId = false;
        $this->hasTermsAndConditions = false;
        $this->hasLastUpdated = false;
    }

    public function withId(string $id): void
    {
        $this->hasId = true;
        $this->id = $id;
    }

    public function withStandard(ConnectorType $standard): void
    {
        $this->hasStandard = true;
        $this->standard = $standard;
    }

    public function withFormat(ConnectorFormat $format): void
    {
        $this->hasFormat = true;
        $this->format = $format;
    }

    public function withPowerType(PowerType $powerType): void
    {
        $this->hasPowerType = true;
        $this->powerType = $powerType;
    }

    public function withVoltage(int $voltage): void
    {
        $this->hasVoltage = true;
        $this->voltage = $voltage;
    }

    public function withAmperage(int $amperage): void
    {
        $this->hasAmperage = true;
        $this->amperage = $amperage;
    }

    public function withTariffId(?string $tariffId): void
    {
        $this->hasTariffId = true;
        $this->tariffId = $tariffId;
    }

    public function withTermsAndConditions(?string $termsAndConditions): void
    {
        $this->hasTermsAndConditions = true;
        $this->termsAndConditions = $termsAndConditions;
    }

    public function withLastUpdated(DateTime $lastUpdated): void
    {
        $this->hasLastUpdated = true;
        $this->lastUpdated = $lastUpdated;
    }

    public function hasId(): bool
    {
        return $this->hasId;
    }

    public function hasStandard(): bool
    {
        return $this->hasStandard;
    }

    public function hasFormat(): bool
    {
        return $this->hasFormat;
    }

    public function hasPowerType(): bool
    {
        return $this->hasPowerType;
    }

    public function hasVoltage(): bool
    {
        return $this->hasVoltage;
    }

    public function hasAmperage(): bool
    {
        return $this->hasAmperage;
    }

    public function hasTariffId(): bool
    {
        return $this->hasTariffId;
    }

    public function hasTermsAndConditions(): bool
    {
        return $this->hasTermsAndConditions;
    }

    public function hasLastUpdated(): bool
    {
        return $this->hasLastUpdated;
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
