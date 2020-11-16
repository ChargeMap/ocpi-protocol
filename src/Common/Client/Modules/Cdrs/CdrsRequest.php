<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client\Modules\Cdrs;

use Chargemap\OCPI\Common\Client\Modules\AbstractRequest;
use Chargemap\OCPI\Common\Client\OcpiModule;

abstract class CdrsRequest extends AbstractRequest
{
    public function getModule(): OcpiModule
    {
        return OcpiModule::CDRS();
    }
}
