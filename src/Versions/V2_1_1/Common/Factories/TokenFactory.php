<?php


namespace Chargemap\OCPI\Versions\V2_1_1\Common\Factories;


use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Token;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\TokenType;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\WhiteList;
use DateTime;
use stdClass;

class TokenFactory
{
    public static function fromJson(?stdClass $json): ?Token
    {
        if ($json === null) {
            return null;
        }

        $token = new Token(
            $json->uid,
            new TokenType($json->type),
            $json->auth_id,
            $json->visual_number ?? null,
            $json->issuer,
            $json->valid,
            new WhiteList($json->whitelist),
            $json->language ?? null,
            new DateTime($json->last_updated)
        );

        return $token;
    }
}