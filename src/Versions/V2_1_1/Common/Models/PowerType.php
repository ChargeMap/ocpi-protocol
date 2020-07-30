<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use MyCLabs\Enum\Enum;

/**
 * @method static self AC_1_PHASE()
 * @method static self AC_3_PHASE()
 * @method static self DC()
 */
class PowerType extends Enum
{
    public const AC_1_PHASE = 'AC_1_PHASE';
    public const AC_3_PHASE = 'AC_3_PHASE';
    public const DC = 'DC';
}
