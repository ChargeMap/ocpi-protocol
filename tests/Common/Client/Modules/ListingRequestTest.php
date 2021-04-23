<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Common\Client\Modules;

use Chargemap\OCPI\Common\Client\Modules\ListingRequest;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class ListingRequestTest extends TestCase
{
    use ListingRequest;

    public function getGetNextOffsetData(): iterable
    {
        yield 'No header' => [
            'expectation' => null,
            'input' => null,
        ];

        yield 'Empty header' => [
            'expectation' => null,
            'input' => [],
        ];

        yield 'Header with nothing' => [
            'expectation' => null,
            'input' => [ '<http://example.com/>; rel="next"'],
        ];

        yield 'Header with offset at 0' => [
            'expectation' => 0,
            'input' => [ '<http://example.com/?offset=0>; rel="next"'],
        ];

        yield 'Header with offset at 1' => [
            'expectation' => 1,
            'input' => [ '<http://example.com/?offset=1>; rel="next"'],
        ];

        yield 'Header with offset at 100' => [
            'expectation' => 100,
            'input' => [ '<http://example.com/?offset=100>; rel="next"'],
        ];

        yield 'Header with offset at 0 at second position' => [
            'expectation' => 0,
            'input' => [ '<http://example.com/?limit=100&offset=0>; rel="next"'],
        ];

        yield 'Header with offset at 1 at second position' => [
            'expectation' => 1,
            'input' => [ '<http://example.com/?limit=100&offset=1>; rel="next"'],
        ];

        yield 'Header with offset at 100 at second position' => [
            'expectation' => 100,
            'input' => [ '<http://example.com/?limit=100&offset=100>; rel="next"'],
        ];
    }

    /**
     * @param int|null $expectation
     * @param string[]|null $input
     * @dataProvider getGetNextOffsetData()
     */
    public function testGetNextOffset(?int $expectation, ?array $input): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->expects(TestCase::once())->method('getHeader')->with('Link')->willReturn($input);

        Assert::assertSame($expectation, $this->getNextOffset($response));
    }

    public function getGetNextLimitData(): iterable
    {
        yield 'No header' => [
            'expectation' => null,
            'input' => null,
        ];

        yield 'Empty header' => [
            'expectation' => null,
            'input' => [],
        ];

        yield 'Header with nothing' => [
            'expectation' => null,
            'input' => [ '<http://example.com/>; rel="next"'],
        ];

        yield 'Header with limit at 0' => [
            'expectation' => null,
            'input' => [ '<http://example.com/?limit=0>; rel="next"'],
        ];

        yield 'Header with limit at 1' => [
            'expectation' => 1,
            'input' => [ '<http://example.com/?limit=1>; rel="next"'],
        ];

        yield 'Header with limit at 100' => [
            'expectation' => 100,
            'input' => [ '<http://example.com/?limit=100>; rel="next"'],
        ];

        yield 'Header with limit at 0 at second position' => [
            'expectation' => null,
            'input' => [ '<http://example.com/?offset=100&limit=0>; rel="next"'],
        ];

        yield 'Header with limit at 1 at second position' => [
            'expectation' => 1,
            'input' => [ '<http://example.com/?offset=100&limit=1>; rel="next"'],
        ];

        yield 'Header with limit at 100 at second position' => [
            'expectation' => 100,
            'input' => [ '<http://example.com/?offset=100&limit=100>; rel="next"'],
        ];
    }

    /**
     * @param int|null $expectation
     * @param string[]|null $input
     * @dataProvider getGetNextLimitData()
     */
    public function testGetNextLimit(?int $expectation, ?array $input): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->expects(TestCase::once())->method('getHeader')->with('Link')->willReturn($input);

        Assert::assertSame($expectation, $this->getNextLimit($response));
    }
}
