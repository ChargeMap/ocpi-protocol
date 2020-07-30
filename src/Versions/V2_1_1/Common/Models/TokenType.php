<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use MyCLabs\Enum\Enum;

/**
 * @method static self RFID()
 * @method static self OTHER()
 */
class TokenType extends Enum
{
    public const RFID = 'RFID';
    public const OTHER = 'OTHER';
}
