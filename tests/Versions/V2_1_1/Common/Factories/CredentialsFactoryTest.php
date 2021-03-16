<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Credentials;
use stdClass;
use PHPUnit\Framework\Assert;

class CredentialsFactoryTest
{
    public static function assertCredentials(?stdClass $json, ?Credentials $credentials): void
    {
        if ($json === null) {
            Assert::assertNull($credentials);
        } else {
            Assert::assertSame($json->url, $credentials->getUrl());
            Assert::assertSame($json->token, $credentials->getToken());
            Assert::assertSame($json->party_id, $credentials->getPartyId());
            Assert::assertSame($json->country_code, $credentials->getCountryCode());
            BusinessDetailsFactoryTest::assertBusinessDetails($json->business_details, $credentials->getBusinessDetails());
        }
    }
}
