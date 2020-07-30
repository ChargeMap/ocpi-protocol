<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use MyCLabs\Enum\Enum;

/**
 * @method static self EV_ONLY()
 * @method static self PLUGGED()
 * @method static self DISABLED()
 * @method static self CUSTOMERS()
 * @method static self MOTORCYCLES()
 */
class ParkingRestriction extends Enum
{
    public const EV_ONLY = 'EV_ONLY';
    public const PLUGGED = 'PLUGGED';
    public const DISABLED = 'DISABLED';
    public const CUSTOMERS = 'CUSTOMERS';
    public const MOTORCYCLES = 'MOTORCYCLES';
}
