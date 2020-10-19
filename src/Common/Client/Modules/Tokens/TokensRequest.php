<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client\Modules\Tokens;


use Chargemap\OCPI\Common\Client\Modules\AbstractRequest;
use Chargemap\OCPI\Common\Client\OcpiModule;

abstract class TokensRequest extends AbstractRequest
{
    public function getModule(): OcpiModule
    {
        return OcpiModule::TOKENS();
    }
}