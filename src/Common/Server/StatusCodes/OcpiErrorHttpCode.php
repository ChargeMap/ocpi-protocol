<?php

namespace Chargemap\OCPI\Common\Server\StatusCodes;

/**
 * @method static self HTTP_BAD_REQUEST()
 * @method static self HTTP_NOT_FOUND()
 * @method static self HTTP_METHOD_NOT_ALLOWED()
 */
class OcpiErrorHttpCode extends OcpiHttpCode
{
    public const HTTP_BAD_REQUEST = 400;
    public const HTTP_NOT_FOUND = 404;
    public const HTTP_METHOD_NOT_ALLOWED = 405;
}
