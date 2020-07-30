<?php

namespace Chargemap\OCPI\Common\Server\StatusCodes;

/**
 * @method static self ERROR_CLIENT()
 * @method static self ERROR_CLIENT_INVALID_PARAMETERS()
 * @method static self ERROR_CLIENT_NOT_ENOUGH_INFO()
 * @method static self ERROR_CLIENT_UNKNOWN_LOCATION()
 */
class OcpiClientErrorStatusCode extends OcpiErrorStatusCode
{
    public const ERROR_CLIENT = 2000;
    public const ERROR_CLIENT_INVALID_PARAMETERS = 2001;
    public const ERROR_CLIENT_NOT_ENOUGH_INFO = 2002;
    public const ERROR_CLIENT_UNKNOWN_LOCATION = 2003;
}
