<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use MyCLabs\Enum\Enum;

/**
 * @method static self ENERGY()
 * @method static self FLAT()
 * @method static self PARKING_TIME()
 * @method static self TIME()
 */
class TariffDimensionType extends Enum
{
    public const ENERGY = 'ENERGY';
    public const FLAT = 'FLAT';
    public const PARKING_TIME = 'PARKING_TIME';
    public const TIME = 'TIME';
}