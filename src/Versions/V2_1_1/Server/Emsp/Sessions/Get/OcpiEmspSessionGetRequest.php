<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Get;

use Chargemap\OCPI\Common\Server\OcpiBaseRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\SessionRequestTrait;
use Psr\Http\Message\RequestInterface;

class OcpiEmspSessionGetRequest extends OcpiBaseRequest
{
    use SessionRequestTrait;

    public function __construct(RequestInterface $request, string $countryCode, string $partyId, string $sessionId)
    {
        parent::__construct($request);
        $this->dispatchParams($countryCode, $partyId, $sessionId);
    }
}
