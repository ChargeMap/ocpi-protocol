<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Cdrs\Get;

use Chargemap\OCPI\Common\Server\OcpiBaseRequest;
use Psr\Http\Message\RequestInterface;

class OcpiEmspCdrGetRequest extends OcpiBaseRequest
{
    private string $cdrId;

    public function __construct(RequestInterface $request, string $cdrId)
    {
        parent::__construct($request);
        $this->cdrId = $cdrId;
    }

    public function getCdrId(): string
    {
        return $this->cdrId;
    }
}
