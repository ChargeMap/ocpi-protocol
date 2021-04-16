<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\FloorLevelFactory;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class FloorLevelFactoryTest extends TestCase
{
    public function getFromStringData(): iterable
    {
        yield 'Null' => [
            'expectation' => null,
            'input' => null,
        ];

        yield 'Sample' => [
            'expectation' => '1',
            'input' => '1'
        ];
    }

    /**
     * @dataProvider getFromStringData()
     */
    public function testFromString(?string $expectation, ?string $input): void
    {
        Assert::assertSame($expectation, FloorLevelFactory::fromString($input));
    }
}
