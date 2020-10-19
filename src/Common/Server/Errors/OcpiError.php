<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Server\Errors;

use Chargemap\OCPI\Common\Server\OcpiErrorResponse;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiErrorHttpCode;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiErrorStatusCode;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiStatusCode;
use Error;
use Psr\Http\Message\ResponseInterface;
use Throwable;

abstract class OcpiError extends Error
{
    protected OcpiStatusCode $ocpiStatusCode;

    public function __construct(OcpiErrorStatusCode $ocpiStatusCode, string $message = "", Throwable $previous = null)
    {
        parent::__construct($message, $ocpiStatusCode->getValue(), $previous);
        $this->ocpiStatusCode = $ocpiStatusCode;
    }

    public function getResponseInterface(OcpiErrorHttpCode $code = null): ResponseInterface
    {
        return static::toOcpiResponse($code)->getResponseInterface();
    }

    abstract public function toOcpiResponse(OcpiErrorHttpCode $code = null): OcpiErrorResponse;
}
