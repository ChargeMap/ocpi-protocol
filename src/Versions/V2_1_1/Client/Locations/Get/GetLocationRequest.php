<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Locations\Get;

use Chargemap\OCPI\Common\Client\Modules\Locations\Get\GetLocationRequest as BaseRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\VersionTrait;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class GetLocationRequest extends BaseRequest
{
    use VersionTrait;

    private string $locationId;

    public function __construct(string $locationId)
    {
        if (strlen($locationId) > 36 || empty($locationId)) {
            throw new InvalidArgumentException('Length of locationId must be between 1 and 36');
        }

        $this->locationId = $locationId;
    }

    public function getLocationId(): string
    {
        return $this->locationId;
    }

    public function getServerRequestInterface(
        ServerRequestFactoryInterface $serverRequestFactory,
        ?StreamFactoryInterface $streamFactory
    ): ServerRequestInterface {
        return $serverRequestFactory->createServerRequest('GET', '/' . $this->locationId);
    }
}
