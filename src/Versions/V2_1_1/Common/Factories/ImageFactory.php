<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Image;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ImageCategory;
use stdClass;

class ImageFactory
{
    public static function fromJson(?stdClass $json): ?Image
    {
        if ($json === null) {
            return null;
        }

        return new Image(
            $json->url,
            property_exists($json, 'thumbnail') ? $json->thumbnail : null,
            new ImageCategory($json->category),
            $json->type,
            property_exists($json, 'width') ? $json->width : null,
            property_exists($json, 'height') ? $json->height : null
        );
    }
}
