<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\SessionFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\AuthenticationMethod;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Session;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\SessionStatus;
use DateTime;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

class SessionFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/Session/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/Session/' . $filename),
                ];
            }
        }
    }

    /**
     * @param string $payload
     * @throws \JsonException
     * @dataProvider getFromJsonData()
     */
    public function testFromJson(string $payload): void
    {
        $json = json_decode($payload, false, 512, JSON_THROW_ON_ERROR);

        $session = SessionFactory::fromJson($json);

        self::assertSession($json, $session);
    }

    public static function assertSession(?stdClass $json, ?Session $session): void
    {
        if ($json === null) {
            Assert::assertNull($session);
        } else {
            Assert::assertSame($json->id, $session->getId());
            Assert::assertEquals(new DateTime($json->start_datetime), $session->getStartDate());
            Assert::assertEquals(isset($json->end_datetime) ? new DateTime($json->end_datetime) : null, $session->getEndDate());
            Assert::assertSame($json->auth_id, $session->getAuthId());
            Assert::assertEquals(new AuthenticationMethod($json->auth_method), $session->getAuthMethod()->getValue());
            Assert::assertSame($json->total_cost ?? null, $session->getTotalCost());
            Assert::assertSame($json->meter_id ?? null, $session->getMeterId());
            Assert::assertSame($json->currency, $session->getCurrency());

            if(isset($json->charging_periods)) {
                Assert::assertSame(count($json->charging_periods), count($session->getChargingPeriods()));

                foreach ($json->charging_periods as $index => $chargingPeriod) {
                    ChargingPeriodFactoryTest::assertChargingPeriod($json->charging_periods[$index], $session->getChargingPeriods()[$index]);
                }
            } else {
                Assert::assertCount(0, $session->getChargingPeriods());
            }


            Assert::assertEquals(new DateTime($json->last_updated), $session->getLastUpdated());
            Assert::assertEquals(new SessionStatus($json->status), $session->getStatus());
            Assert::assertSame((float)$json->kwh, $session->getKwh());

            LocationFactoryTest::assertLocation($json->location, $session->getLocation());
        }
    }
}