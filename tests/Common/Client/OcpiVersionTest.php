<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Common\Client;

use Chargemap\OCPI\Common\Client\OcpiVersion;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class OcpiVersionTest extends TestCase
{
    public function getIsGreaterThanData(): iterable
    {
        yield 'Same value' => [
            'a' => OcpiVersion::V2_1_1(),
            'b' => OcpiVersion::V2_1_1(),
            'expectation' => false,
        ];

        yield 'Greater than' => [
            'a' => OcpiVersion::V2_1_1(),
            'b' => OcpiVersion::V2_0(),
            'expectation' => true,
        ];

        yield 'Not greater than' => [
            'a' => OcpiVersion::V2_0(),
            'b' => OcpiVersion::V2_1_1(),
            'expectation' => false,
        ];
    }

    /**
     * @param \Chargemap\OCPI\Common\Client\OcpiVersion $a
     * @param \Chargemap\OCPI\Common\Client\OcpiVersion $b
     * @param bool $expectation
     * @dataProvider getIsGreaterThanData()
     */
    public function testIsGreaterThan(OcpiVersion $a, OcpiVersion $b, bool $expectation): void
    {
        Assert::assertSame($expectation, $a->isGreaterThan($b));
    }
}
