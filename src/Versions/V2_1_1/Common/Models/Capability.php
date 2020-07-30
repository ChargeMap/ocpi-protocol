<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use MyCLabs\Enum\Enum;

/**
 * @method static self CHARGING_PROFILE_CAPABLE()
 * @method static self CREDIT_CARD_PAYABLE()
 * @method static self REMOTE_START_STOP_CAPABLE()
 * @method static self RESERVABLE()
 * @method static self RFID_READER()
 * @method static self UNLOCK_CAPABLE()
 */
class Capability extends Enum
{
    public const CHARGING_PROFILE_CAPABLE = 'CHARGING_PROFILE_CAPABLE';
    public const CREDIT_CARD_PAYABLE = 'CREDIT_CARD_PAYABLE';
    public const REMOTE_START_STOP_CAPABLE = 'REMOTE_START_STOP_CAPABLE';
    public const RESERVABLE = 'RESERVABLE';
    public const RFID_READER = 'RFID_READER';
    public const UNLOCK_CAPABLE = 'UNLOCK_CAPABLE';
}
