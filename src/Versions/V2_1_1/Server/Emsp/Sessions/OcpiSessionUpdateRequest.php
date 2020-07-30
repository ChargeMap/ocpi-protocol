<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions;

use Chargemap\OCPI\Common\Server\OcpiUpdateRequest;
use InvalidArgumentException;
use Psr\Http\Message\RequestInterface;

abstract class OcpiSessionUpdateRequest extends OcpiUpdateRequest
{
    protected string $countryCode;

    protected string $partyId;

    protected string $sessionId;

    protected function __construct(RequestInterface $request, string $countryCode, string $partyId, string $sessionId)
    {
        if (empty($countryCode) || mb_strlen($countryCode) !== 2) {
            throw new InvalidArgumentException('Country code should contain exactly 2 letters.');
        }

        if (empty ($partyId) || mb_strlen($partyId) !== 3) {
            throw new InvalidArgumentException('Party ID should contain exactly 3 characters.');
        }

        if (empty($sessionId) || mb_strlen($sessionId) > 36) {
            throw new InvalidArgumentException('Session ID should contain less than 36 characters.');
        }
        parent::__construct($request);

        $this->countryCode = $countryCode;
        $this->partyId = $partyId;
        $this->sessionId = $sessionId;
    }

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
}
