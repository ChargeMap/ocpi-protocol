<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use MyCLabs\Enum\Enum;

/**
 * @method static self CHARGER()
 * @method static self ENTRANCE()
 * @method static self LOCATION()
 * @method static self NETWORK()
 * @method static self OPERATOR()
 * @method static self OTHER()
 * @method static self OWNER()
 */
class ImageCategory extends Enum
{
    public const CHARGER = 'CHARGER';
    public const ENTRANCE = 'ENTRANCE';
    public const LOCATION = 'LOCATION';
    public const NETWORK = 'NETWORK';
    public const OPERATOR = 'OPERATOR';
    public const OTHER = 'OTHER';
    public const OWNER = 'OWNER';
}
