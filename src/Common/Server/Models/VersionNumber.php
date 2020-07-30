<?php

namespace Chargemap\OCPI\Common\Server\Models;

use MyCLabs\Enum\Enum;

/**
 * @method static self VERSION_2_0()
 * @method static self VERSION_2_1_1()
 */
class VersionNumber extends Enum
{
    public const VERSION_2_0 = '2.0';
    public const VERSION_2_1_1 = '2.1.1';
}
