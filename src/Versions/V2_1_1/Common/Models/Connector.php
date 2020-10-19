<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;


use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use DateTime;
use JsonSerializable;

class Connector implements JsonSerializable
{
    private string $id;

    private ConnectorType $standard;

    private ConnectorFormat $format;

    private PowerType $powerType;

    private int $voltage;

    private int $amperage;

    private ?string $tariffId;

    private ?string $termsAndConditions;

    private DateTime $lastUpdated;

    /**
     * Connector constructor.
     * @param string $id
     * @param ConnectorType $standard
     * @param ConnectorFormat $format
     * @param PowerType $powerType
     * @param int $voltage
     * @param int $amperage
     * @param string|null $tariffId
     * @param string|null $termsAndConditions
     * @param DateTime $lastUpdated
     */
    public function __construct(string $id, ConnectorType $standard, ConnectorFormat $format, PowerType $powerType, int $voltage, int $amperage, ?string $tariffId, ?string $termsAndConditions, DateTime $lastUpdated)
    {
        $this->id = $id;
        $this->standard = $standard;
        $this->format = $format;
        $this->powerType = $powerType;
        $this->voltage = $voltage;
        $this->amperage = $amperage;
        $this->tariffId = $tariffId;
        $this->termsAndConditions = $termsAndConditions;
        $this->lastUpdated = $lastUpdated;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getStandard(): ConnectorType
    {
        return $this->standard;
    }

    public function getFormat(): ConnectorFormat
    {
        return $this->format;
    }

    public function getPowerType(): PowerType
    {
        return $this->powerType;
    }

    public function getVoltage(): int
    {
        return $this->voltage;
    }

    public function getAmperage(): int
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

    public function getLastUpdated(): DateTime
    {
        return $this->lastUpdated;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'id' => $this->id,
            'standard' => $this->standard,
            'format' => $this->format,
            'power_type' => $this->powerType,
            'voltage' => $this->voltage,
            'amperage' => $this->amperage,
            'last_updated' => DateTimeFormatter::format($this->lastUpdated),
        ];

        if ($this->tariffId !== null) {
            $return['tariff_id'] = $this->tariffId;
        }

        if ($this->termsAndConditions !== null) {
            $return['terms_and_conditions'] = $this->termsAndConditions;
        }

        return $return;
    }
}
