<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use MyCLabs\Enum\Enum;

/**
 * @method static self ENERGY()
 * @method static self FLAT()
 * @method static self MAX_CURRENT()
 * @method static self MIN_CURRENT()
 * @method static self PARKING_TIME()
 * @method static self TIME()
 */
class CdrDimensionType extends Enum
{
    public const ENERGY = 'ENERGY';
    public const FLAT = 'FLAT';
    public const MAX_CURRENT = 'MAX_CURRENT';
    public const MIN_CURRENT = 'MIN_CURRENT';
    public const PARKING_TIME = 'PARKING_TIME';
    public const TIME = 'TIME';
}
