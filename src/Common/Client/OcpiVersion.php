<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Client;

use InvalidArgumentException;
use MyCLabs\Enum\Enum;

/**
 * @method static self V1_9()
 * @method static self V2_0()
 * @method static self V2_1_0()
 * @method static self V2_1_1()
 */
class OcpiVersion extends Enum
{
    public const V1_9 = 'V1_9';
    public const V2_0 = 'V2_0';
    public const V2_1_0 = 'V2_1_0';
    public const V2_1_1 = 'V2_1_1';

    public static function fromVersionNumber(string $versionNumber): self
    {
        switch ($versionNumber) {
            case '1.9':
                return self::V1_9();
            case '2.0':
                return self::V2_0();
            case '2.1.0':
                return self::V2_1_0();
            case '2.1.1':
                return self::V2_1_1();
        }

        throw new InvalidArgumentException(sprintf('Unable to parse version %s', $versionNumber));
    }
}
