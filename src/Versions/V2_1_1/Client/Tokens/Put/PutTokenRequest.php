<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client\Tokens\Put;

use Chargemap\OCPI\Common\Client\Modules\Tokens\Put\PutTokenRequest as BaseRequest;
use Chargemap\OCPI\Versions\V2_1_1\Client\VersionTrait;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ModuleId;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Token;
use Http\Discovery\Psr17FactoryDiscovery;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class PutTokenRequest extends BaseRequest
{
    use VersionTrait;

    private string $countryCode;
    private string $partyId;
    private string $tokenUid;
    private Token $token;

    public function __construct(string $countryCode, string $partyId, string $tokenUid, Token $token)
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
        $this->token = $token;
    }

    public function getModule(): ModuleId
    {
        return ModuleId::TOKENS();
    }

    public function getServerRequestInterface(ServerRequestFactoryInterface $serverRequestFactory, ?StreamFactoryInterface $streamFactory): ServerRequestInterface
    {
        if ($streamFactory === null) {
            $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        }

        return $serverRequestFactory->createServerRequest('PUT',
            '/' . $this->countryCode . '/' . $this->partyId . '/' . $this->tokenUid)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($streamFactory->createStream(json_encode($this->token)));
    }
}