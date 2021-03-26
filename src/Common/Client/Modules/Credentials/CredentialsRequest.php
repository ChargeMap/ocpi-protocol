<?php
declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client\Modules\Credentials;

use Chargemap\OCPI\Common\Client\Modules\AbstractRequest;
use Chargemap\OCPI\Common\Client\OcpiModule;

abstract class CredentialsRequest extends AbstractRequest
{
    public function getModule(): OcpiModule
    {
        return OcpiModule::CREDENTIALS();
    }
}