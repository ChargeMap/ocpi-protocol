<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Patch;


use Chargemap\OCPI\Common\Client\Modules\Tokens\Patch\PatchTokenRequest as BaseRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\VersionTrait;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PartialToken;
use Http\Discovery\Psr17FactoryDiscovery;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class PatchTokenRequest extends BaseRequest
{
    use VersionTrait;

    private string $countryCode;
    private string $partyId;
    private string $tokenUid;
    private PartialToken $partialToken;

    public function __construct(string $countryCode, string $partyId, string $tokenUid, PartialToken $partialToken)
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
        $this->partialToken = $partialToken;
    }

    public function getServerRequestInterface(ServerRequestFactoryInterface $serverRequestFactory, ?StreamFactoryInterface $streamFactory): ServerRequestInterface
    {
        if ($streamFactory === null) {
            $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        }

        return $serverRequestFactory->createServerRequest('PATCH',
            '/' . $this->countryCode . '/' . $this->partyId . '/' . $this->tokenUid)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($streamFactory->createStream(json_encode($this->partialToken)));
    }
}