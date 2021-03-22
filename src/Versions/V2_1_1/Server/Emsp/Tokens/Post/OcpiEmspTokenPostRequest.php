<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Tokens\Post;

use Chargemap\OCPI\Common\Server\OcpiBaseRequest;
use Chargemap\OCPI\Common\Utils\PayloadValidation;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\LocationReferencesFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\LocationReferences;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\TokenType;
use Psr\Http\Message\ServerRequestInterface;
use stdClass;

class OcpiEmspTokenPostRequest extends OcpiBaseRequest
{
    private ?stdClass $jsonBody;

    private string $tokenId;

    private TokenType $tokenType;

    private ?LocationReferences $locationReferences;

    public function __construct(ServerRequestInterface $request, string $tokenUid)
    {
        parent::__construct($request);

        $params = $request->getQueryParams();

        $tokenType = array_key_exists('type', $params) ? new TokenType(mb_strtoupper($params['type'])) : TokenType::RFID();

        $this->tokenId = $tokenUid;
        $this->tokenType = $tokenType;
        $this->jsonBody = null;
        $this->locationReferences = null;

        if (!empty($request->getBody()->__toString())) {
            $this->jsonBody = json_decode($request->getBody()->__toString());
            PayloadValidation::coerce('Tokens/tokenPostRequest.schema.json', $this->jsonBody);

            $this->locationReferences = LocationReferencesFactory::fromJson($this->jsonBody);
        }
    }

    public function getJsonBody(): ?stdClass
    {
        return $this->jsonBody;
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
