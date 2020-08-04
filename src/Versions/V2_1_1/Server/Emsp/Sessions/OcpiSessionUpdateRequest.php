<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions;

use Chargemap\OCPI\Common\Server\OcpiUpdateRequest;
use Psr\Http\Message\RequestInterface;

abstract class OcpiSessionUpdateRequest extends OcpiUpdateRequest
{
    use SessionRequestTrait;

    protected function __construct(RequestInterface $request, string $countryCode, string $partyId, string $sessionId)
    {
        parent::__construct($request);
        $this->dispatchParams($countryCode, $partyId, $sessionId);
    }
}
