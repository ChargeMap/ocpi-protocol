<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\OcpiLocationUpdateRequest;
use InvalidArgumentException;
use Psr\Http\Message\RequestInterface;

abstract class BaseEvseUpdateRequest extends OcpiLocationUpdateRequest
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
