<?php
declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\EnvironmentalImpact;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\EnvironmentalImpactCategory;
use stdClass;

class EnvironmentalImpactFactory
{
    public static function fromJson(?stdClass $json): ?EnvironmentalImpact
    {
        if( $json === null) {
            return null;
        }

        return new EnvironmentalImpact(
            new EnvironmentalImpactCategory($json->source),
            $json->amount
        );
    }
}