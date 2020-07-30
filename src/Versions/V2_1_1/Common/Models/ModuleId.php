<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use MyCLabs\Enum\Enum;

/**
 * @method static self CDRS()
 * @method static self COMMANDS()
 * @method static self CRED_AND_REG()
 * @method static self LOCATIONS()
 * @method static self SESSION()
 * @method static self TARIFFS()
 * @method static self TOKENS()
 */
class ModuleId extends Enum
{
    public const CDRS = 'cdrs';
    public const COMMANDS = 'commands';
    public const CRED_AND_REG = 'credentials';
    public const LOCATIONS = 'locations';
    public const SESSION = 'sessions';
    public const TARIFFS = 'tariffs';
    public const TOKENS = 'tokens';
}