<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Put;

use Chargemap\OCPI\Common\Utils\PayloadValidation;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\SessionFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Session;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\OcpiSessionUpdateRequest;
use Psr\Http\Message\RequestInterface;
use UnexpectedValueException;

class OcpiEmspSessionPutRequest extends OcpiSessionUpdateRequest
{
    private Session $session;

    public function __construct(RequestInterface $request, string $countryCode, string $partyId, string $sessionId)
    {
        parent::__construct($request, $countryCode, $partyId, $sessionId);
        PayloadValidation::coerce('Versions/V2_1_1/Server/Emsp/Schemas/sessionPut.schema.json', $this->jsonBody);
        $session = SessionFactory::fromJson($this->jsonBody);
        if ($session === null) {
            throw new UnexpectedValueException('Session cannot be null');
        }
        $this->session = $session;
    }

    public function getSession(): Session
    {
        return $this->session;
    }
}
