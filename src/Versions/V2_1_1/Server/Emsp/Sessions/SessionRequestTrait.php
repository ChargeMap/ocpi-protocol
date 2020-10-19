<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions;

use Chargemap\OCPI\Common\Server\Errors\OcpiGenericClientError;

trait SessionRequestTrait
{
    protected string $countryCode;

    protected string $partyId;

    protected string $sessionId;

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function getPartyId(): string
    {
        return $this->partyId;
    }

    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    protected function dispatchParams(string $countryCode, string $partyId, string $sessionId)
    {
        if (empty($countryCode) || mb_strlen($countryCode) !== 2) {
            throw new OcpiGenericClientError('Country code should contain exactly 2 letters.');
        }

        if (empty ($partyId) || mb_strlen($partyId) !== 3) {
            throw new OcpiGenericClientError('Party ID should contain exactly 3 characters.');
        }

        if (empty($sessionId) || mb_strlen($sessionId) > 36) {
            throw new OcpiGenericClientError('Session ID should contain less than 36 characters.');
        }
        $this->countryCode = $countryCode;
        $this->partyId = $partyId;
        $this->sessionId = $sessionId;
    }
}
