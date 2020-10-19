<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client;

use MyCLabs\Enum\Enum;

/**
 * @method static self CDRS()
 * @method static self COMMANDS()
 * @method static self CREDENTIALS()
 * @method static self LOCATIONS()
 * @method static self SESSIONS()
 * @method static self TARIFFS()
 * @method static self TOKENS()
 */
class OcpiModule extends Enum
{
    public const CDRS = 'cdrs';
    public const COMMANDS = 'commands';
    public const CREDENTIALS = 'credentials';
    public const LOCATIONS = 'locations';
    public const SESSIONS = 'sessions';
    public const TARIFFS = 'tariffs';
    public const TOKENS = 'tokens';
}
