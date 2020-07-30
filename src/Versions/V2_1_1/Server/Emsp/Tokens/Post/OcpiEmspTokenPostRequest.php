<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Tokens\Post;

use Chargemap\OCPI\Common\Server\OcpiUpdateRequest;
use Chargemap\OCPI\Common\Utils\PayloadValidation;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\LocationReferences;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\TokenType;
use Psr\Http\Message\RequestInterface;

class OcpiEmspTokenPostRequest extends OcpiUpdateRequest
{
    private string $tokenId;

    private TokenType $tokenType;

    private ?LocationReferences $locationReferences;

    public function __construct(RequestInterface $request, string $tokenUid)
    {
        parent::__construct($request);

        $params = [];
        parse_str($request->getUri()->getQuery(), $params);
        $tokenType = array_key_exists('type', $params) ? new TokenType(mb_strtoupper($params['type'])) : TokenType::RFID();

        if (!empty($request->getBody()->__toString())) {
            $json = json_decode($request->getBody()->__toString());
            PayloadValidation::coerce('Versions/V2_1_1/Server/Emsp/Schemas/tokenPost.schema.json', $json);
            $locationReferences = new LocationReferences($json->location_id);

            if (property_exists($json, 'evse_uids') && is_array($json->evse_uids)) {
                foreach ($json->evse_uids as $evseUid) {
                    $locationReferences->addEvseUid($evseUid);
                }
            }

            if (property_exists($json, 'connector_ids') && is_array($json->connector_ids)) {
                foreach ($json->connector_ids as $connectorId) {
                    $locationReferences->addConnectorId($connectorId);
                }
            }
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
