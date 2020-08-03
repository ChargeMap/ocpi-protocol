<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Get;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Get\OcpiEmspLocationGetRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use InvalidArgumentException;
use Psr\Http\Message\RequestInterface;

class OcpiEmspEvseGetRequest extends OcpiEmspLocationGetRequest
{
    protected string $evseUid;

    protected function __construct(RequestInterface $request, LocationRequestParams $params)
    {
        parent::__construct($request, $params);
        $evseUid = $params->getEvseUid();
        if ($evseUid === null) {
            throw new InvalidArgumentException('EVSE UID should be provided.');
        }
        $this->evseUid = $evseUid;
    }

    public function getEvseUid(): string
    {
        return $this->evseUid;
    }
}
