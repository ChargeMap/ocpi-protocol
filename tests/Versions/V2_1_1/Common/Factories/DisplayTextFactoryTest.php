<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\DisplayTextFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\DisplayText;
use JsonException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;
use Tests\Chargemap\OCPI\InvalidPayloadException;
use Tests\Chargemap\OCPI\OcpiTestCase;

class DisplayTextFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/DisplayText/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/DisplayText/' . $filename),
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

        OcpiTestCase::coerce('V2_1_1/Common/common.schema.json#/definitions/display_text', $json );

        $displayText = DisplayTextFactory::fromJson($json);

        self::assertDisplayText($json, $displayText);
    }

    public static function assertDisplayText(?stdClass $json, ?DisplayText $displayText): void
    {
        if($json === null) {
            Assert::assertNull($displayText);
        } else {
            Assert::assertSame($json->language, $displayText->getLanguage());
            Assert::assertSame($json->text, $displayText->getText());
        }
    }
}