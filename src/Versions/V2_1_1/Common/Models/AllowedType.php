<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use MyCLabs\Enum\Enum;

/**
 * @method static self ALLOWED()
 * @method static self BLOCKED()
 * @method static self EXPIRED()
 * @method static self NO_CREDIT()
 * @method static self NOT_ALLOWED()
 */
class AllowedType extends Enum
{
    public const ALLOWED = 'ALLOWED';
    public const BLOCKED = 'BLOCKED';
    public const EXPIRED = 'EXPIRED';
    public const NO_CREDIT = 'NO_CREDIT';
    public const NOT_ALLOWED = 'NOT_ALLOWED';
}
