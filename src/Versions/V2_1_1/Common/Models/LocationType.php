<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use MyCLabs\Enum\Enum;

/**
 * @method static self ON_STREET()
 * @method static self PARKING_GARAGE()
 * @method static self UNDERGROUND_GARAGE()
 * @method static self PARKING_LOT()
 * @method static self OTHER()
 * @method static self UNKNOWN()
 */
class LocationType extends Enum
{
    /**
     * Parking in public space.
     * @var string
     */
    public const ON_STREET = 'ON_STREET';

    /**
     * Multistorey car park.
     * @var string
     */
    public const PARKING_GARAGE = 'PARKING_GARAGE';

    /**
     * Multistorey car park, mainly underground.
     * @var string
     */
    public const UNDERGROUND_GARAGE = 'UNDERGROUND_GARAGE';

    /**
     * A cleared area that is intended for parking vehicles, i.e. at super markets, bars, etc.
     * @var string
     */
    public const PARKING_LOT = 'PARKING_LOT';

    /**
     * None of the given possibilities.
     * @var string
     */
    public const OTHER = 'OTHER';

    /**
     * Parking location type is not known by the operator (default).
     * @var string
     */
    public const UNKNOWN = 'UNKNOWN';
}
