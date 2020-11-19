<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\EnergyMix;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\EnergySource;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\EnergySourceCategory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\EnvironmentalImpact;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\EnvironmentalImpactCategory;
use stdClass;

class EnergyMixFactory
{
    public static function fromJson(?stdClass $json): ?EnergyMix
    {
        if ($json === null) {
            return null;
        }

        $energyMix = new EnergyMix(
            $json->is_green_energy,
            property_exists($json, 'supplier_name') ? $json->supplier_name : null,
            property_exists($json, 'energy_product_name') ? $json->energy_product_name : null
        );

        if (property_exists($json, 'energy_sources')) {
            foreach ($json->energy_sources as $source) {
                $energyMix->addEnergySource(EnergySourceFactory::fromJson($source));
            }
        }

        if (property_exists($json, 'environ_impact')) {
            foreach ($json->environ_impact as $impact) {
                $energyMix->addEnvironImpact(EnvironmentalImpactFactory::fromJson($impact));
            }
        }

        return $energyMix;
    }
}
