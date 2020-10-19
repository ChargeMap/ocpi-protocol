<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use MyCLabs\Enum\Enum;

/**
 * @method static self AUTH_REQUEST()
 * @method static self WHITELIST()
 */
class AuthenticationMethod extends Enum
{
    public const AUTH_REQUEST = 'AUTH_REQUEST';
    public const WHITELIST = 'WHITELIST';
}
