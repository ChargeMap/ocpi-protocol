<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class OcpiResponseTestCase extends OcpiTestCase
{
    /** @return ResponseInterface|MockObject */
    public function createResponseInterface(string $payload)
    {
        $streamInterface = $this->createMock(StreamInterface::class);

        // The body contents must be read
        $invokerCountMatcher = TestCase::once();

        $streamInterface->expects($invokerCountMatcher)->method('__toString')->willReturn($payload);
        $streamInterface->expects($invokerCountMatcher)->method('getContents')->willReturn($payload);

        $responseInterface = $this->createMock(ResponseInterface::class);

        $responseInterface->expects(TestCase::atLeastOnce())->method('getBody')->willReturn($streamInterface);

        return $responseInterface;
    }
}