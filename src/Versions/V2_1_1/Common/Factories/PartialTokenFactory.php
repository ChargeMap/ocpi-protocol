<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PartialToken;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\TokenType;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\WhiteList;
use DateTime;
use stdClass;

class PartialTokenFactory
{
    public static function fromJson(?stdClass $json): ?PartialToken
    {
        if ($json === null) {
            return null;
        }

        $token = new PartialToken(
            $json->uid ?? null,
            property_exists($json, 'type') ? new TokenType($json->type) : null,
            $json->auth_id ?? null,
            $json->visual_number ?? null,
            $json->issuer ?? null,
            $json->valid ?? null,
            property_exists($json, 'whitelist') ? new WhiteList($json->whitelist) : null,
            $json->language ?? null,
            property_exists($json, 'last_updated') ? new DateTime($json->last_updated) : null
        );

        return $token;
    }
}