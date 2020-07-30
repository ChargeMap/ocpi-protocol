<?php

namespace Chargemap\OCPI\Common\Server\StatusCodes;

/**
 * @method static self ERROR_SERVER()
 * @method static self ERROR_SERVER_UNABLE_TO_USE()
 * @method static self ERROR_SERVER_UNSUPPORTED_VERSION()
 * @method static self ERROR_SERVER_NO_MATCHING_ENDPOINTS()
 */
class OcpiServerErrorStatusCode extends OcpiErrorStatusCode
{
    public const ERROR_SERVER = 3000;
    public const ERROR_SERVER_UNABLE_TO_USE = 3001;
    public const ERROR_SERVER_UNSUPPORTED_VERSION = 3002;
    public const ERROR_SERVER_NO_MATCHING_ENDPOINTS = 3003;
}