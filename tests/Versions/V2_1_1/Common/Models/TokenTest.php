<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Token;
use PHPUnit\Framework\Assert;
use stdClass;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Common\Models\Token
 */
class TokenTest
{
    public static function assertJsonSerialization(?Token $token, ?stdClass $json): void
    {
        if ($token === null) {
            Assert::assertNull($json);
        } else {
            Assert::assertSame($token->getUid(), $json->uid);
            Assert::assertSame($token->getType()->getValue(), $json->type);
            Assert::assertSame($token->getAuthId(), $json->auth_id);
            Assert::assertSame($token->getVisualNumber(), $json->visual_number);
            Assert::assertSame($token->getIssuer(), $json->issuer);
            Assert::assertSame($token->isValid(), $json->valid);
            Assert::assertSame($token->getWhiteList()->getValue(), $json->whitelist);
            Assert::assertSame($token->getLanguage(), $json->language);
            Assert::assertSame(DateTimeFormatter::format($token->getLastUpdated()), $json->last_updated);

        }
    }
}
