<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use MyCLabs\Enum\Enum;

/**
 * @method static self SOCKET()
 * @method static self CABLE()
 */
class ConnectorFormat extends Enum
{
    public const SOCKET = 'SOCKET';
    public const CABLE = 'CABLE';
}
