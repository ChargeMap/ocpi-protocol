<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client;

use Chargemap\OCPI\Common\Client\OcpiVersion;

trait VersionTrait
{
    public function getVersion(): OcpiVersion
    {
        return OcpiVersion::V2_1_1();
    }
}
