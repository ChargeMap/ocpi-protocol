<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use MyCLabs\Enum\Enum;

/**
 * @method static self AVAILABLE()
 * @method static self BLOCKED()
 * @method static self CHARGING()
 * @method static self INOPERATIVE()
 * @method static self OUTOFORDER()
 * @method static self PLANNED()
 * @method static self REMOVED()
 * @method static self RESERVED()
 * @method static self UNKNOWN()
 */
class EVSEStatus extends Enum
{
    public const AVAILABLE = 'AVAILABLE';
    public const BLOCKED = 'BLOCKED';
    public const CHARGING = 'CHARGING';
    public const INOPERATIVE = 'INOPERATIVE';
    public const OUTOFORDER = 'OUTOFORDER';
    public const PLANNED = 'PLANNED';
    public const REMOVED = 'REMOVED';
    public const RESERVED = 'RESERVED';
    public const UNKNOWN = 'UNKNOWN';
}
