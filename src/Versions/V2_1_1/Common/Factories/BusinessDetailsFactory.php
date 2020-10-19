<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\BusinessDetails;
use stdClass;

class BusinessDetailsFactory
{
    public static function fromJson(?stdClass $json): ?BusinessDetails
    {
        if ($json === null) {
            return null;
        }

        return new BusinessDetails($json->name,
            property_exists($json, 'website') ? $json->website : null,
            property_exists($json, 'logo') ? ImageFactory::fromJson($json->logo) : null
        );
    }
}
