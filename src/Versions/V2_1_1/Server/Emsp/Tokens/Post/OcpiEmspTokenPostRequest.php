<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Tokens\Post;

use Chargemap\OCPI\Common\Server\OcpiBaseRequest;
use Chargemap\OCPI\Common\Utils\PayloadValidation;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\LocationReferencesFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\LocationReferences;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\TokenType;
use Psr\Http\Message\ServerRequestInterface;

class OcpiEmspTokenPostRequest extends OcpiBaseRequest
{
    private string $tokenId;

    private TokenType $tokenType;

    private ?LocationReferences $locationReferences;

    public function __construct(ServerRequestInterface $request, string $tokenUid)
    {
        parent::__construct($request);

        $params = $request->getQueryParams();

        $tokenType = array_key_exists('type', $params) ? new TokenType(mb_strtoupper($params['type'])) : TokenType::RFID();

        if (!empty($request->getBody()->__toString())) {
            $json = json_decode($request->getBody()->__toString());
            PayloadValidation::coerce('Versions/V2_1_1/Server/Emsp/Schemas/tokenPost.schema.json', $json);

            $locationReferences = LocationReferencesFactory::fromJson($json);
        } else {
            $locationReferences = null;
        }

        $this->tokenId = $tokenUid;
        $this->tokenType = $tokenType;
        $this->locationReferences = $locationReferences;
    }

    public function getTokenId(): string
    {
        return $this->tokenId;
    }

    public function getTokenType(): TokenType
    {
        return $this->tokenType;
    }

    public function getLocationReferences(): ?LocationReferences
    {
        return $this->locationReferences;
    }
}
