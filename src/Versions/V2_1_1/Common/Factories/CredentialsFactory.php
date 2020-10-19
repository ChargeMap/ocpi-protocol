<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Credentials;
use stdClass;

class CredentialsFactory
{
    public static function fromJson(?stdClass $json): ?Credentials
    {
        if ($json === null) {
            return null;
        }

        return new Credentials(
            $json->token,
            $json->url,
            BusinessDetailsFactory::fromJson($json->business_details),
            $json->party_id,
            $json->country_code
        );
    }
}
