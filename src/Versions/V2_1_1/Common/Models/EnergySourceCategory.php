<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use MyCLabs\Enum\Enum;

/**
 * @method static self NUCLEAR()
 * @method static self GENERAL_FOSSIL()
 * @method static self COAL()
 * @method static self GAS()
 * @method static self GENERAL_GREEN()
 * @method static self SOLAR()
 * @method static self WIND()
 * @method static self WATER()
 */
class EnergySourceCategory extends Enum
{
    public const NUCLEAR = 'NUCLEAR';
    public const GENERAL_FOSSIL = 'GENERAL_FOSSIL';
    public const COAL = 'COAL';
    public const GAS = 'GAS';
    public const GENERAL_GREEN = 'GENERAL_GREEN';
    public const SOLAR = 'SOLAR';
    public const WIND = 'WIND';
    public const WATER = 'WATER';
}
