<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\CredentialsFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Credentials;
use JsonException;
use PHPUnit\Framework\TestCase;
use stdClass;
use PHPUnit\Framework\Assert;
use Tests\Chargemap\OCPI\InvalidPayloadException;
use Tests\Chargemap\OCPI\OcpiTestCase;

class CredentialsFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/Credentials/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/Credentials/' . $filename),
                ];
            }
        }
    }

    /**
     * @param string $payload
     * @throws JsonException|InvalidPayloadException
     * @dataProvider getFromJsonData()
     */
    public function testFromJson(string $payload): void
    {
        $json = json_decode($payload, false, 512, JSON_THROW_ON_ERROR);

        OcpiTestCase::coerce(  'V2_1_1/Common/credentials.schema.json', $json );

        $credentials = CredentialsFactory::fromJson($json);

        self::assertCredentials($json, $credentials);
    }

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
