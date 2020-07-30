<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Tariff;
use DateTime;
use stdClass;

class TariffFactory
{
    /**
     * @param stdClass[]|null $json
     * @return Tariff[]
     */
    public static function arrayFromJsonArray(?array $json): ?array
    {
        if ($json === null) {
            return null;
        }

        $tariffs = [];

        foreach ($json as $jsonTariff) {
            $tariffs[] = self::fromJson($jsonTariff);
        }

        return $tariffs;
    }

    public static function fromJson(?stdClass $json): ?Tariff
    {
        if ($json === null) {
            return null;
        }

        $tariff = new Tariff(
            $json->id,
            $json->currency,
            $json->tariff_alt_url ?? null,
            EnergyMixFactory::fromJson($json->energy_mix ?? null),
            new DateTime($json->last_updated)
        );

        if (property_exists($json, 'tariff_alt_text')) {
            foreach (DisplayTextFactory::arrayFromJsonArray($json->tariff_alt_text) as $displayText) {
                $tariff->addTariffAltText($displayText);
            }
        }

        foreach ($json->elements as $jsonTariffElement) {
            $tariff->addTariffElement(TariffElementFactory::fromJson($jsonTariffElement));
        }

        return $tariff;
    }
}
