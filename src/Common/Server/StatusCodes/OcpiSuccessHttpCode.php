<?php

namespace Chargemap\OCPI\Common\Server\StatusCodes;

/**
 * @method static self HTTP_OK()
 * @method static self HTTP_CREATED()
 */
class OcpiSuccessHttpCode extends OcpiHttpCode
{
    public const HTTP_OK = 200;
    public const HTTP_CREATED = 201;
}
