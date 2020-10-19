<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Server\Versions\V2_1_1\Emsp\Locations;

use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\LocationRequestParams;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class LocationRequestParamsTest extends TestCase
{

    public function invalidParametersProvider(): array
    {
        return [
            ['', 'TNM', 'LOC1'],
            ['F', 'TNM', 'LOC1'],
            ['FR', '', 'LOC1'],
            ['FR', 'T', 'LOC1'],
            ['FR', 'TNM', ''],
            ['FR', 'TNM', 'LOC1', ''],
            ['FR', 'TNM', 'LOC1', '', ''],
            ['FR', 'TNM', 'LOC1', '3256', ''],
        ];
    }

    /**
     * @dataProvider invalidParametersProvider
     * @param string $countryCode
     * @param string $partyId
     * @param string $locationId
     * @param string|null $evseId
     * @param string|null $connectorId
     */
    public function testShouldFailWithInvalidParameters(string $countryCode, string $partyId, string $locationId, string $evseId = null, string $connectorId = null): void
    {
        $this->expectException(InvalidArgumentException::class);
        new LocationRequestParams($countryCode, $partyId, $locationId, $evseId, $connectorId);
    }
}
