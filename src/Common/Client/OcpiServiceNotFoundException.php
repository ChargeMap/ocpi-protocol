<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client;

use Exception;
use Throwable;

class OcpiServiceNotFoundException extends Exception
{
    private OcpiVersion $version;

    private string $requestClassName;

    public function __construct(OcpiVersion $version, string $className, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->version = $version;
        $this->requestClassName = $className;
    }

    public function getVersion(): OcpiVersion
    {
        return $this->version;
    }

    public function getRequestClassName(): string
    {
        return $this->requestClassName;
    }
}
