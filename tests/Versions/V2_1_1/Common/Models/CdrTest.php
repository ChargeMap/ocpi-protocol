<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\CdrFactory;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

class CdrTest extends TestCase
{
    /**
     * @return mixed[][]
     */
    public function getJsonSerializeData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/Cdrs') as $file) {
            if ($file !== '.' && $file !== '..') {
                yield $file => [
                    'payload' => json_decode(file_get_contents(__DIR__ . '/Payloads/Cdrs/' . $file)),
                ];
            }
        }
    }

    /**
     * @param stdClass $payload
     * @dataProvider getJsonSerializeData()
     * @covers \Chargemap\OCPI\Versions\V2_1_1\Common\Models\Cdr::jsonSerialize()
     */
    public function testJsonSerialize(stdClass $payload): void
    {
        $cdr = CdrFactory::fromJson($payload);

        Assert::assertEquals( $payload, json_decode(json_encode($cdr)));
    }
}