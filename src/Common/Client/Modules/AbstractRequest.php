<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client\Modules;

use Chargemap\OCPI\Common\Models\BaseModuleId;
use Chargemap\OCPI\Common\Client\OcpiVersion;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

abstract class AbstractRequest
{
    abstract public function getModule(): BaseModuleId;

    abstract public function getVersion(): OcpiVersion;

    abstract public function getServerRequestInterface(ServerRequestFactoryInterface $serverRequestFactory, ?StreamFactoryInterface $streamFactory): ServerRequestInterface;
}
