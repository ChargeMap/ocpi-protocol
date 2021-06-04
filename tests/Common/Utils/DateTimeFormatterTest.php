<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Common\Utils;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use DateTime;
use DateTimeInterface;
use DateTimeZone;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class DateTimeFormatterTest extends TestCase
{
    public function getFormatData(): iterable
    {
        yield 'Null' => [
            'expectation' => null,
            'dateTime' => null,
        ];

        yield 'UTC date' => [
            'expectation' => '2020-08-07T11:30:00Z',
            'dateTime' => new DateTime('2020-08-07 11:30:00', new DateTimeZone('UTC')),
        ];

        yield 'Non-UTC date' => [
            'expectation' => '2020-08-07T11:30:00Z',
            'dateTime' => new DateTime('2020-08-07 13:30:00', new DateTimeZone('Europe/Paris')),
        ];
    }

    /**
     * @param string|null $expectation
     * @param DateTimeInterface|null $dateTime
     * @covers       \Chargemap\OCPI\Common\Utils\DateTimeFormatter::format()
     * @dataProvider getFormatData()
     */
    public function testFormat(?string $expectation, ?DateTimeInterface $dateTime): void
    {
        Assert::assertSame($expectation, DateTimeFormatter::format($dateTime));
    }
}