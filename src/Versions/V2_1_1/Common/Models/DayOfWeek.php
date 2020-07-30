<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use MyCLabs\Enum\Enum;

/**
 * @method static self MONDAY()
 * @method static self TUESDAY()
 * @method static self WEDNESDAY()
 * @method static self THURSDAY()
 * @method static self FRIDAY()
 * @method static self SATURDAY()
 * @method static self SUNDAY()
 */
class DayOfWeek extends Enum
{
    public const MONDAY = 'MONDAY';
    public const TUESDAY = 'TUESDAY';
    public const WEDNESDAY = 'WEDNESDAY';
    public const THURSDAY = 'THURSDAY';
    public const FRIDAY = 'FRIDAY';
    public const SATURDAY = 'SATURDAY';
    public const SUNDAY = 'SUNDAY';
}
