<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations;

use Chargemap\OCPI\Common\Server\OcpiUpdateRequest;
use Psr\Http\Message\RequestInterface;

abstract class OcpiLocationUpdateRequest extends OcpiUpdateRequest
{
    use LocationRequestTrait;

    protected function __construct(RequestInterface $request, LocationRequestParams $params)
    {
        parent::__construct($request);
        $this->dispatchParams($params);
    }
}
