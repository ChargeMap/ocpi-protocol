<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Get;

use Chargemap\OCPI\Common\Server\OcpiBaseRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestTrait;
use Psr\Http\Message\RequestInterface;

class OcpiEmspLocationGetRequest extends OcpiBaseRequest
{
    use LocationRequestTrait;

    public function __construct(RequestInterface $request, LocationRequestParams $params)
    {
        parent::__construct($request);
        $this->dispatchParams($params);
    }
}
