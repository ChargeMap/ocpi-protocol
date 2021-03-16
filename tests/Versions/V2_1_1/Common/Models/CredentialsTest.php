<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Credentials;
use PHPUnit\Framework\Assert;
use stdClass;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Common\Models\Credentials
 */
class CredentialsTest
{
    public static function assertJsonSerialize(?Credentials $credentials, ?stdClass $json): void
    {
        if ($credentials === null) {
            Assert::assertNull($json);
        } else {
            Assert::assertSame($credentials->getUrl(), $json->url);
            Assert::assertSame($credentials->getToken(), $json->token);
            Assert::assertSame($credentials->getPartyId(), $json->party_id);
            Assert::assertSame($credentials->getCountryCode(), $json->country_code);
            BusinessDetailsTest::assertJsonSerialization($credentials->getBusinessDetails(), $json->business_details);
        }
    }
}
