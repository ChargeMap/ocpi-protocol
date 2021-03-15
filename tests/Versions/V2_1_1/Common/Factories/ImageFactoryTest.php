<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\ImageFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Image;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ImageCategory;
use JsonException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;
use Tests\Chargemap\OCPI\InvalidPayloadException;
use Tests\Chargemap\OCPI\OcpiTestCase;

class ImageFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/Image') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/Image/' . $filename),
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

        OcpiTestCase::coerce( realpath( __DIR__.'/../../../../../src/Versions/V2_1_1/Server/Emsp/Schemas/common.json' ). '#/definitions/image', $json );

        $image = ImageFactory::fromJson($json);

        self::assertImage($json, $image);
    }

    public static function assertImage(?stdClass $json, ?Image $image): void
    {
        if($json === null) {
            Assert::assertNull($image);
        } else {
            Assert::assertSame($json->url, $image->getUrl());
            Assert::assertSame($json->thumbnail ?? null, $image->getThumbnail());
            Assert::assertEquals(new ImageCategory($json->category), $image->getCategory());
            Assert::assertSame($json->type , $image->getType());
            Assert::assertSame($json->width ?? null, $image->getWidth());
            Assert::assertSame($json->height ?? null, $image->getHeight());
        }
    }
}