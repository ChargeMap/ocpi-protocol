<?php
declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client;

use Exception;

class UnsupportedVersionException extends Exception
{
    public function __construct(OcpiModule $module, OcpiVersion $version)
    {
        parent::__construct('Module '.$module->getValue().' at version '.$version->getValue().' is currently not supported' );
    }
}