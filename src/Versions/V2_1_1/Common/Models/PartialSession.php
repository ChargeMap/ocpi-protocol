<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use Chargemap\OCPI\Common\Utils\PartialModel;
use DateTime;
use JsonSerializable;

/**
 * @method bool hasId()
 * @method bool hasStartDate()
 * @method bool hasEndDate()
 * @method bool hasKwh()
 * @method bool hasAuthId()
 * @method bool hasAuthMethod()
 * @method bool hasLocation()
 * @method bool hasMeterId()
 * @method bool hasCurrency()
 * @method bool hasChargingPeriods()
 * @method bool hasTotalCost()
 * @method bool hasStatus()
 * @method bool hasLastUpdated()
 * @method self withId(?string $id)
 * @method self withStartDate(?DateTime $startDate)
 * @method self withEndDate(?DateTime $endDate)
 * @method self withKwh(?float $kwh)
 * @method self withAuthId(?string $authId)
 * @method self withAuthMethod(?AuthenticationMethod $authMethod)
 * @method self withLocation(?Location $location)
 * @method self withMeterId(?string $meterId)
 * @method self withCurrency(?string $currency)
 * @method self withChargingPeriods()
 * @method self withTotalCost(?float $totalCost)
 * @method self withStatus(?SessionStatus $status)
 * @method self withLastUpdated(?DateTime $lastUpdated)
 */
class PartialSession extends PartialModel implements JsonSerializable
{
    private ?string $id = null;
    private ?DateTime $startDate = null;
    private ?DateTime $endDate = null;
    private ?float $kwh = null;
    private ?string $authId = null;
    private ?AuthenticationMethod $authMethod = null;
    private ?Location $location = null;
    private ?string $meterId = null;
    private ?string $currency = null;
    /** @var ChargingPeriod[]|null */
    private ?array $chargingPeriods = null;
    private ?float $totalCost = null;
    private ?SessionStatus $status = null;
    private ?DateTime $lastUpdated = null;

    protected function _withId(?string $id): self
    {
        $this->id = $id;
        return $this;
    }

    protected function _withStartDate(?DateTime $startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }

    protected function _withEndDate(?DateTime $endDate): self
    {
        $this->endDate = $endDate;
        return $this;
    }

    protected function _withKwh(?float $kwh): self
    {
        $this->kwh = $kwh;
        return $this;
    }

    protected function _withAuthId(?string $authId): self
    {
        $this->authId = $authId;
        return $this;
    }

    protected function _withAuthMethod(?AuthenticationMethod $authMethod): self
    {
        $this->authMethod = $authMethod;
        return $this;
    }

    protected function _withLocation(?Location $location): self
    {
        $this->location = $location;
        return $this;
    }

    protected function _withMeterId(?string $meterId): self
    {
        $this->meterId = $meterId;
        return $this;
    }

    protected function _withCurrency(?string $currency): self
    {
        $this->currency = $currency;
        return $this;
    }

    protected function _withChargingPeriods(): self
    {
        $this->chargingPeriods = [];
        return $this;
    }

    public function withChargingPeriod(ChargingPeriod $period): self
    {
        $this->chargingPeriods[] = $period;
        return $this;
    }

    protected function _withTotalCost(?float $totalCost): self
    {
        $this->totalCost = $totalCost;
        return $this;
    }

    protected function _withStatus(?SessionStatus $status): self
    {
        $this->status = $status;
        return $this;
    }

    protected function _withLastUpdated(?DateTime $lastUpdated): self
    {
        $this->lastUpdated = $lastUpdated;
        return $this;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getStartDate(): ?DateTime
    {
        return $this->startDate;
    }

    public function getEndDate(): ?DateTime
    {
        return $this->endDate;
    }

    public function getKwh(): ?float
    {
        return $this->kwh;
    }

    public function getAuthId(): ?string
    {
        return $this->authId;
    }

    public function getAuthMethod(): ?AuthenticationMethod
    {
        return $this->authMethod;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function getMeterId(): ?string
    {
        return $this->meterId;
    }

    public function getChargingPeriods(): ?array
    {
        return $this->chargingPeriods;
    }

    public function getTotalCost(): ?float
    {
        return $this->totalCost;
    }

    public function getStatus(): ?SessionStatus
    {
        return $this->status;
    }

    public function getLastUpdated(): ?DateTime
    {
        return $this->lastUpdated;
    }

    public function jsonSerialize(): array
    {
        $return = [];

        if ($this->hasId()) {
            $return['id'] = $this->id;
        }
        if ($this->hasStartDate()) {
            $return['start_datetime'] = DateTimeFormatter::format($this->startDate);
        }
        if ($this->hasKwh()) {
            $return['kwh'] = $this->kwh;
        }
        if ($this->hasAuthId()) {
            $return['auth_id'] = $this->authId;
        }
        if ($this->hasAuthMethod()) {
            $return['auth_method'] = $this->authMethod;
        }
        if ($this->hasLocation()) {
            $return['location'] = $this->location;
        }
        if ($this->hasCurrency()) {
            $return['currency'] = $this->currency;
        }
        if ($this->hasChargingPeriods()) {
            $return['charging_periods'] = $this->chargingPeriods;
        }
        if ($this->hasStatus()) {
            $return['status'] = $this->status;
        }
        if ($this->hasLastUpdated()) {
            $return['last_updated'] = DateTimeFormatter::format($this->lastUpdated);
        }
        if ($this->hasMeterId()) {
            $return['meter_id'] = $this->meterId;
        }
        if ($this->hasTotalCost()) {
            $return['total_cost'] = $this->totalCost;
        }
        if ($this->hasEndDate()) {
            $return['end_datetime'] = DateTimeFormatter::format($this->endDate);
        }
        return $return;
    }
}
