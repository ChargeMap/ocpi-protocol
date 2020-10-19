<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Get;

use Chargemap\OCPI\Common\Client\Modules\Tokens\Get\GetTokenRequest as BaseRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\VersionTrait;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class GetTokenRequest extends BaseRequest
{
    use VersionTrait;

    private string $countryCode;
    private string $partyId;
    private string $tokenUid;

    public function __construct(string $countryCode, string $partyId, string $tokenUid)
    {
        if (strlen($countryCode) !== 2) {
            throw new InvalidArgumentException("Length of countryCode must be 2");
        }

        if (strlen($partyId) !== 3) {
            throw new InvalidArgumentException("Length of partyId must be 3");
        }

        if (strlen($tokenUid) > 36 || empty($tokenUid)) {
            throw new InvalidArgumentException("Length of tokenUid must be between 1 and 36");
        }

        $this->partyId = $partyId;
        $this->tokenUid = $tokenUid;
        $this->countryCode = $countryCode;
    }

    public function getServerRequestInterface(ServerRequestFactoryInterface $serverRequestFactory, ?StreamFactoryInterface $streamFactory): ServerRequestInterface
    {
        return $serverRequestFactory->createServerRequest('GET', '/' . $this->countryCode . '/' . $this->partyId . '/' . $this->tokenUid);
    }
}
