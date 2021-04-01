<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Models;

use Chargemap\OCPI\Common\Models\BaseModuleId;
use Chargemap\OCPI\Common\Client\OcpiVersion;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ModuleId;
use Psr\Http\Message\UriInterface;

abstract class BaseEndpoint
{
    abstract public function getModuleId(): BaseModuleId;

    abstract public function getUrl(): string;
}
