<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\DisplayText;
use stdClass;

class DisplayTextFactory
{
    /**
     * @param stdClass[]|null $json
     * @return DisplayText[]
     */
    public static function arrayFromJsonArray(?array $json): ?array
    {
        if ($json === null) {
            return null;
        }

        $texts = [];

        foreach ($json as $jsonDisplayText) {
            $texts[] = self::fromJson($jsonDisplayText);
        }

        return $texts;
    }

    public static function fromJson(?stdClass $json): ?DisplayText
    {
        if ($json === null) {
            return null;
        }

        return new DisplayText($json->language, $json->text);
    }
}
