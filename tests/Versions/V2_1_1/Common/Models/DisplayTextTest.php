<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\DisplayText;
use PHPUnit\Framework\Assert;
use stdClass;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Common\Models\DisplayText
 */
class DisplayTextTest
{
    public static function assertJsonSerialization(?DisplayText $displayText, ?stdClass $json): void
    {
        if ($displayText === null) {
            Assert::assertNull($json);
        } else {
            Assert::assertSame($displayText->getLanguage(), $json->language);
            Assert::assertSame($displayText->getText(), $json->text);
        }
    }
}
