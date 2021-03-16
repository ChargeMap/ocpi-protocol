<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\LocationReferences;
use PHPUnit\Framework\Assert;
use stdClass;

class LocationReferencesTest
{
    public static function assertJsonSerialization(?LocationReferences $locationReferences, ?stdClass $json): void
    {
        if ($locationReferences === null) {
            Assert::assertNull($json);
        } else {
            Assert::assertSame($locationReferences->getLocationId(), $json->location_id);
            if (empty($locationReferences->getEvseUids())) {
                Assert::assertEmpty($json->evse_uids);
            } else {
                foreach ($locationReferences->getEvseUids() as $index => $evseUid) {
                    Assert::assertSame($locationReferences->getEvseUids()[$index], $json->evse_uids[$index]);
                }
            }
            if (empty($locationReferences->getConnectorIds())) {
                Assert::assertEmpty($json->connector_ids);
            } else {
                foreach ($locationReferences->getConnectorIds() as $index => $connectorId) {
                    Assert::assertSame($locationReferences->getConnectorIds()[$index], $json->connector_ids[$index]);
                }
            }
        }
    }
}
