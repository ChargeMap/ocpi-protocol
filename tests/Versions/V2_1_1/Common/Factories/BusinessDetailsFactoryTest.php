<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\BusinessDetailsFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\BusinessDetails;
use JsonException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;
use Tests\Chargemap\OCPI\InvalidPayloadException;
use Tests\Chargemap\OCPI\OcpiTestCase;

class BusinessDetailsFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/BusinessDetails/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/BusinessDetails/' . $filename),
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

        OcpiTestCase::coerce( 'Common/common.schema.json#/definitions/business_details', $json );

        $businessDetails = BusinessDetailsFactory::fromJson($json);

        self::assertBusinessDetails($json, $businessDetails);
    }

    public static function assertBusinessDetails(?stdClass $json, ?BusinessDetails $businessDetails): void
    {
        if($json === null) {
            Assert::assertNull($businessDetails);
        } else {
            Assert::assertSame($json->name, $businessDetails->getName());
            ImageFactoryTest::assertImage($json->logo ?? null, $businessDetails->getLogo());
            Assert::assertSame($json->website ?? null, $businessDetails->getWebsite());
        }
    }
}