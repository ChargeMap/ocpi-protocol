<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\ImageFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Image;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ImageCategory;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

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
     * @throws \JsonException
     * @dataProvider getFromJsonData()
     */
    public function testFromJson(string $payload): void
    {
        $json = json_decode($payload, false, 512, JSON_THROW_ON_ERROR);

        $businessDetails = ImageFactory::fromJson($json);

        self::assertImage($json, $businessDetails);
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