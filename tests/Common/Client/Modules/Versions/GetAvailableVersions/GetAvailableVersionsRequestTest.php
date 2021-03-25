<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Common\Client\Modules\Versions\GetAvailableVersions;

use Chargemap\OCPI\Common\Client\Modules\Versions\GetAvailableVersions\GetAvailableVersionsRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

class GetAvailableVersionsRequestTest extends TestCase
{
    public function testGetServerRequestInterface()
    {
        $request = new GetAvailableVersionsRequest('http://example.com');

        $serverRequestFactory = $this->createMock(ServerRequestFactoryInterface::class);
        $streamFactory = $this->createMock(StreamFactoryInterface::class);

        // Must create a GET request on the provided url
        $serverRequestFactory->expects(TestCase::once())->method('createServerRequest')->with('GET', 'http://example.com');

        // Never creates a body, it's a GET request
        $streamFactory->expects(TestCase::never())->method('createStream');

        $request->getServerRequestInterface($serverRequestFactory, $streamFactory);
    }
}
