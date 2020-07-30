<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use MyCLabs\Enum\Enum;

/**
 * @method static self NUCLEAR_WASTE()
 * @method static self CARBON_DIOXIDE()
 */
class EnvironmentalImpactCategory extends Enum
{
    public const NUCLEAR_WASTE = 'NUCLEAR_WASTE';
    public const CARBON_DIOXIDE = 'CARBON_DIOXIDE';
}
