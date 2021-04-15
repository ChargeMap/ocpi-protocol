<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\PhysicalReferenceFactory;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class PhysicalReferenceFactoryTest extends TestCase
{
    public function getFromStringData(): iterable
    {
        yield 'Null' => [
            'expectation' => null,
            'input' => null,
        ];

        yield 'Sample' => [
            'expectation' => 'sample',
            'input' => 'sample'
        ];
    }

    /**
     * @dataProvider getFromStringData()
     */
    public function testFromString(?string $expectation, ?string $input): void
    {
        Assert::assertSame($expectation, PhysicalReferenceFactory::fromString($input));
    }
}
