<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\LocationFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\PartialSessionFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\SessionFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\AuthenticationMethod;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\CdrDimension;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\CdrDimensionType;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ChargingPeriod;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Location;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Session;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\SessionStatus;
use DateTime;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Common\Models\Session
 */
class SessionTest extends TestCase
{
    public static function assertJsonSerialization(?Session $session, ?stdClass $json): void
    {
        if ($session === null) {
            Assert::assertNull($json);
        } else {
            Assert::assertSame($session->getId(), $json->id);
            Assert::assertSame(DateTimeFormatter::format($session->getStartDate()), $json->start_datetime);

            if (is_null($json->end_datetime ?? null)) {
                Assert::assertNull($session->getEndDate());
            } else {
                Assert::assertSame(DateTimeFormatter::format($session->getEndDate()), $json->end_datetime);
            }

            Assert::assertEquals($session->getKwh(), $json->kwh);
            Assert::assertSame($session->getAuthId(), $json->auth_id);
            Assert::assertSame($session->getAuthMethod()->getValue(), $json->auth_method);
            LocationTest::assertJsonSerialization($session->getLocation(), $json->location);
            Assert::assertSame($session->getMeterId(), $json->meter_id ?? null);
            Assert::assertSame($session->getCurrency(), $json->currency);
            Assert::assertCount(count($session->getChargingPeriods()), $json->charging_periods);
            foreach ($session->getChargingPeriods() as $index => $chargingPeriod) {
                ChargingPeriodTest::assertJsonSerialization($chargingPeriod, $json->charging_periods[$index]);
            }
            Assert::assertEquals($session->getTotalCost(), $json->total_cost);
            Assert::assertSame($session->getStatus()->getValue(), $json->status);
            Assert::assertSame(DateTimeFormatter::format($session->getLastUpdated()), $json->last_updated);
        }
    }

    public function pathAndPropertyProvider(): array
    {
        return [
            'id' => [__DIR__ . '/Payloads/Sessions/SessionPatchIdPayload.json', 'getId'],
            'start date' => [__DIR__ . '/Payloads/Sessions/SessionPatchStartDatetimePayload.json', 'getStartDate'],
            'end date' => [__DIR__ . '/Payloads/Sessions/SessionPatchEndDatetimePayload.json', 'getEndDate'],
            'kwh' => [__DIR__ . '/Payloads/Sessions/SessionPatchKwhPayload.json', 'getKwh'],
            'auth id' => [__DIR__ . '/Payloads/Sessions/SessionPatchAuthIdPayload.json', 'getAuthId'],
            'auth method' => [__DIR__ . '/Payloads/Sessions/SessionPatchAuthMethodPayload.json', 'getAuthMethod'],
            'location' => [__DIR__ . '/Payloads/Sessions/SessionPatchLocationPayload.json', 'getLocation'],
            'meter id' => [__DIR__ . '/Payloads/Sessions/SessionPatchMeterIdPayload.json', 'getMeterId'],
            'currency' => [__DIR__ . '/Payloads/Sessions/SessionPatchCurrencyPayload.json', 'getCurrency'],
            'total cost' => [__DIR__ . '/Payloads/Sessions/SessionPatchTotalCostPayload.json', 'getTotalCost'],
            'status' => [__DIR__ . '/Payloads/Sessions/SessionPatchStatusPayload.json', 'getStatus'],
            'last update' => [__DIR__ . '/Payloads/Sessions/SessionPatchLastUpdatedPayload.json', 'getLastUpdated'],
            'charging periods' => [
                __DIR__ . '/Payloads/Sessions/SessionPatchChargingPeriodsPayload.json',
                'getChargingPeriods'
            ],
        ];
    }

    /**
     * @dataProvider pathAndPropertyProvider
     * @param string $path
     * @param string $accessor
     */
    public function testShouldCorrectlyMergeWithPartialSession(string $path, string $accessor): void
    {
        $session = SessionFactory::fromJson(json_decode(file_get_contents(__DIR__ . '/Payloads/Sessions/SessionPutPayload.json')));
        $partialSession = PartialSessionFactory::fromJson(json_decode(file_get_contents($path)));

        $newSession = $session->merge($partialSession);
        $this->assertSame($partialSession->$accessor(), $newSession->$accessor());
    }

    public function getDumbSession(): Session
    {
        return new Session(
            'id1',
            (new DateTime())->setTimestamp(123456789),
            (new DateTime())->setTimestamp(918273645),
            22.345,
            'authId1',
            AuthenticationMethod::AUTH_REQUEST(),
            $this->createMock(Location::class),
            'meterId1',
            'currency1',
            50.123,
            SessionStatus::PENDING(),
            (new DateTime())->setTimestamp(11111111),
        );
    }

    public function periodsDiffTestProvider(): iterable
    {
        yield 'both has no charging periods' => [[], [], null];

        $startDate1 = (new DateTime())->setTimestamp(123456789);
        $startDate2 = (new DateTime())->setTimestamp(987654321);

        $chargingPeriod = new ChargingPeriod($startDate1);
        $chargingPeriod->addDimension(new CdrDimension(CdrDimensionType::TIME(), 0.5));

        yield 'both has same charging period with one dimension' => [[$chargingPeriod], [$chargingPeriod], null];

        $chargingPeriod2 = new ChargingPeriod($startDate2);
        $chargingPeriod2->addDimension(new CdrDimension(CdrDimensionType::ENERGY(), 1231.134));

        yield 'both has same charging periods with one dimension' => [
            [$chargingPeriod, $chargingPeriod2],
            [$chargingPeriod, $chargingPeriod2],
            null
        ];

        $chargingPeriod = new ChargingPeriod($startDate1);
        $chargingPeriod->addDimension(new CdrDimension(CdrDimensionType::TIME(), 0.5));
        $chargingPeriod->addDimension(new CdrDimension(CdrDimensionType::MAX_CURRENT(), 0.23423));

        $chargingPeriod2 = new ChargingPeriod($startDate2);
        $chargingPeriod2->addDimension(new CdrDimension(CdrDimensionType::ENERGY(), 1231.134));
        $chargingPeriod2->addDimension(new CdrDimension(CdrDimensionType::TIME(), 2342.234));
        yield 'both has same charging periods with multiple dimensions' => [
            [$chargingPeriod, $chargingPeriod2],
            [$chargingPeriod, $chargingPeriod2],
            null
        ];

        yield 'both has same charging periods with multiple dimensions added in different order' => [
            [$chargingPeriod2, $chargingPeriod],
            [$chargingPeriod, $chargingPeriod2],
            null
        ];

        yield 'first session has no period' => [
            [],
            [$chargingPeriod, $chargingPeriod2],
            [$chargingPeriod, $chargingPeriod2],
        ];

        yield 'second session has no period' => [
            [$chargingPeriod, $chargingPeriod2],
            [],
            []
        ];

        $chargingPeriod = new ChargingPeriod($startDate1);
        $chargingPeriod->addDimension(new CdrDimension(CdrDimensionType::TIME(), 0.5));

        $chargingPeriodModified = new ChargingPeriod($startDate1);
        $chargingPeriodModified->addDimension(new CdrDimension(CdrDimensionType::TIME(), 1.0));

        yield 'second session has changed a dimension volume' => [
            [$chargingPeriod],
            [$chargingPeriodModified],
            [$chargingPeriodModified]
        ];

        $chargingPeriodModified = new ChargingPeriod($startDate1);
        $chargingPeriodModified->addDimension(new CdrDimension(CdrDimensionType::TIME(), 0.5));
        $chargingPeriodModified->addDimension(new CdrDimension(CdrDimensionType::MAX_CURRENT(), 0.23423));

        yield 'second session has added a dimension to the period' => [
            [$chargingPeriod],
            [$chargingPeriodModified],
            [$chargingPeriodModified]
        ];

        yield 'second session has deleted a dimension from the period' => [
            [$chargingPeriodModified],
            [$chargingPeriod],
            [$chargingPeriod]
        ];

        yield 'second session has added one more period' => [
            [$chargingPeriod],
            [$chargingPeriod, $chargingPeriod2],
            [$chargingPeriod2]
        ];

        $chargingPeriod2 = new ChargingPeriod($startDate2);
        $chargingPeriod2->addDimension(new CdrDimension(CdrDimensionType::TIME(), 1.0));

        yield 'second session has modified first period and added one more' => [
            [$chargingPeriod],
            [$chargingPeriodModified, $chargingPeriod2],
            [$chargingPeriodModified, $chargingPeriod2]
        ];
    }

    /**
     * @dataProvider periodsDiffTestProvider
     * @param array $chargingPeriods1
     * @param array $chargingPeriods2
     * @param array|null $expectation
     */
    public function testChargingPeriodsDiff(
        array $chargingPeriods1,
        array $chargingPeriods2,
        ?array $expectation
    ): void {
        $session1 = $this->getDumbSession();
        foreach ($chargingPeriods1 as $chargingPeriod) {
            $session1->addChargingPeriod($chargingPeriod);
        }
        $session2 = $this->getDumbSession();
        foreach ($chargingPeriods2 as $chargingPeriod) {
            $session2->addChargingPeriod($chargingPeriod);
        }

        $diff = Session::chargingPeriodsDiff($session1, $session2);
        $this->assertSame($expectation, $diff);
    }

    public function diffTestProvider(): iterable
    {
        $id1 = 'id1';
        $id2 = 'id2';
        $startDate1 = (new DateTime())->setTimestamp(123456789);
        $startDate2 = (new DateTime())->setTimestamp(987654321);
        $endDate1 = (new DateTime())->setTimestamp(918273645);
        $endDate2 = (new DateTime())->setTimestamp(564738291);
        $kwh1 = 22.345;
        $kwh2 = 55.132;
        $authId1 = 'authId1';
        $authId2 = 'authId2';
        $authMethod1 = AuthenticationMethod::AUTH_REQUEST();
        $authMethod2 = AuthenticationMethod::WHITELIST();
        $location1 = LocationFactory::fromJson(json_decode(file_get_contents(__DIR__ . '/Payloads/Location/bessancourt.json')));
        $location2 = LocationFactory::fromJson(json_decode(file_get_contents(__DIR__ . '/Payloads/Location/sample1.json')));
        $meterId1 = 'meterId1';
        $meterId2 = 'meterId2';
        $currency1 = 'EUR';
        $currency2 = 'USD';
        $totalCost1 = 50.123;
        $totalCost2 = 12.543;
        $status1 = SessionStatus::PENDING();
        $status2 = SessionStatus::ACTIVE();
        $lastUpdated1 = (new DateTime())->setTimestamp(11111111);
        $lastUpdated2 = (new DateTime())->setTimestamp(22222222);

        $session1 = new Session(
            $id1,
            $startDate1,
            $endDate1,
            $kwh1,
            $authId1,
            $authMethod1,
            $location1,
            $meterId1,
            $currency1,
            $totalCost1,
            $status1,
            $lastUpdated1,
        );

        $session2 = new Session(
            $id1,
            $startDate1,
            $endDate1,
            $kwh1,
            $authId1,
            $authMethod1,
            $location1,
            $meterId1,
            $currency1,
            $totalCost1,
            $status1,
            $lastUpdated1,
        );
        yield 'no difference' => [
            'first' => $session1,
            'second' => $session2,
            'hassersWithExpectation' => [
                'hasId' => false,
                'hasStartDate' => false,
                'hasEndDate' => false,
                'hasKwh' => false,
                'hasAuthId' => false,
                'hasAuthMethod' => false,
                'hasLocation' => false,
                'hasMeterId' => false,
                'hasCurrency' => false,
                'hasChargingPeriods' => false,
                'hasTotalCost' => false,
                'hasStatus' => false,
                'hasLastUpdated' => false,
            ],
            'accessorsWithExpectation' => []
        ];

        $session2 = new Session(
            $id2,
            $startDate2,
            $endDate2,
            $kwh2,
            $authId2,
            $authMethod2,
            $location2,
            $meterId2,
            $currency2,
            $totalCost2,
            $status2,
            $lastUpdated2,
        );
        $session2->addChargingPeriod($this->createMock(ChargingPeriod::class));

        yield 'full difference' => [
            'first' => $session1,
            'second' => $session2,
            'hassersWithExpectation' => [
                'hasId' => true,
                'hasStartDate' => true,
                'hasEndDate' => true,
                'hasKwh' => true,
                'hasAuthId' => true,
                'hasAuthMethod' => true,
                'hasLocation' => true,
                'hasMeterId' => true,
                'hasCurrency' => true,
                'hasChargingPeriods' => true,
                'hasTotalCost' => true,
                'hasStatus' => true,
                'hasLastUpdated' => true,
            ],
            'accessorsWithExpectation' => [
                'getId' => $session2->getId(),
                'getStartDate' => $session2->getStartDate(),
                'getEndDate' => $session2->getEndDate(),
                'getKwh' => $session2->getKwh(),
                'getAuthId' => $session2->getAuthId(),
                'getAuthMethod' => $session2->getAuthMethod(),
                'getLocation' => $session2->getLocation(),
                'getMeterId' => $session2->getMeterId(),
                'getCurrency' => $session2->getCurrency(),
                'getTotalCost' => $session2->getTotalCost(),
                'getStatus' => $session2->getStatus(),
                'getLastUpdated' => $session2->getLastUpdated(),
                'getChargingPeriods' => $session2->getChargingPeriods()
            ]
        ];

        $session2 = new Session(
            $id2,
            $startDate1,
            $endDate1,
            $kwh1,
            $authId1,
            $authMethod1,
            $location1,
            $meterId1,
            $currency1,
            $totalCost1,
            $status1,
            $lastUpdated1,
        );

        yield 'id only' => [
            'first' => $session1,
            'second' => $session2,
            'hassersWithExpectation' => [
                'hasId' => true,
                'hasStartDate' => false,
                'hasEndDate' => false,
                'hasKwh' => false,
                'hasAuthId' => false,
                'hasAuthMethod' => false,
                'hasLocation' => false,
                'hasMeterId' => false,
                'hasCurrency' => false,
                'hasChargingPeriods' => false,
                'hasTotalCost' => false,
                'hasStatus' => false,
                'hasLastUpdated' => false,
            ],
            'accessorsWithExpectation' => [
                'getId' => $session2->getId()
            ]
        ];

        $session1 = new Session(
            $id1,
            $startDate1,
            null,
            $kwh1,
            $authId1,
            $authMethod1,
            $location1,
            $meterId1,
            $currency1,
            $totalCost1,
            $status1,
            $lastUpdated1,
        );

        $session2 = new Session(
            $id1,
            $startDate1,
            $endDate2,
            $kwh2,
            $authId1,
            $authMethod1,
            $location1,
            $meterId1,
            $currency1,
            $totalCost2,
            $status1,
            $lastUpdated2,
        );

        yield 'most important params' => [
            'first' => $session1,
            'second' => $session2,
            'hassersWithExpectation' => [
                'hasId' => false,
                'hasStartDate' => false,
                'hasEndDate' => true,
                'hasKwh' => true,
                'hasAuthId' => false,
                'hasAuthMethod' => false,
                'hasLocation' => false,
                'hasMeterId' => false,
                'hasCurrency' => false,
                'hasChargingPeriods' => false,
                'hasTotalCost' => true,
                'hasStatus' => false,
                'hasLastUpdated' => true,
            ],
            'accessorsWithExpectation' => [
                'getEndDate' => $session2->getEndDate(),
                'getKwh' => $session2->getKwh(),
                'getTotalCost' => $session2->getTotalCost(),
                'getLastUpdated' => $session2->getLastUpdated()
            ]
        ];

        $session1 = new Session(
            $id1,
            $startDate1,
            null,
            $kwh1,
            $authId1,
            $authMethod1,
            $location1,
            $meterId1,
            $currency1,
            $totalCost1,
            $status1,
            $lastUpdated1,
        );

        $chargingPeriod = new ChargingPeriod($startDate1);
        $chargingPeriod->addDimension(new CdrDimension(CdrDimensionType::TIME(), 0.5));

        $session1->addChargingPeriod($chargingPeriod);

        $session2 = new Session(
            $id1,
            $startDate1,
            null,
            $kwh1,
            $authId1,
            $authMethod1,
            $location1,
            $meterId1,
            $currency1,
            $totalCost1,
            $status1,
            $lastUpdated1,
        );

        $chargingPeriodModified = new ChargingPeriod($startDate1);
        $chargingPeriodModified->addDimension(new CdrDimension(CdrDimensionType::TIME(), 1.0));
        $chargingPeriod2 = new ChargingPeriod($startDate2);
        $chargingPeriod2->addDimension(new CdrDimension(CdrDimensionType::TIME(), 1.0));

        $session2->addChargingPeriod($chargingPeriodModified);
        $session2->addChargingPeriod($chargingPeriod2);

        yield 'charging periods' => [
            'first' => $session1,
            'second' => $session2,
            'hassersWithExpectation' => [
                'hasId' => false,
                'hasStartDate' => false,
                'hasEndDate' => false,
                'hasKwh' => false,
                'hasAuthId' => false,
                'hasAuthMethod' => false,
                'hasLocation' => false,
                'hasMeterId' => false,
                'hasCurrency' => false,
                'hasChargingPeriods' => true,
                'hasTotalCost' => false,
                'hasStatus' => false,
                'hasLastUpdated' => false,
            ],
            'accessorsWithExpectation' => [
                'getChargingPeriods' => Session::chargingPeriodsDiff($session1, $session2),
            ]
        ];

    }

    /**
     * @dataProvider diffTestProvider
     * @param \Chargemap\OCPI\Versions\V2_1_1\Common\Models\Session $first
     * @param \Chargemap\OCPI\Versions\V2_1_1\Common\Models\Session $second
     * @param array<string, bool> $hassersWithExpectation
     * @param array<string, mixed> $accessorsWithExpectation
     */
    public function testShouldReturnCorrectDiff(
        Session $first,
        Session $second,
        array $hassersWithExpectation,
        array $accessorsWithExpectation
    ): void {
        $diff = $first->diff($second);
        foreach ($hassersWithExpectation as $hasser => $expectation) {
            $this->assertSame($expectation, $diff->$hasser(), "$hasser is not " . ($expectation ? 'true' : 'false'));
        }
        foreach ($accessorsWithExpectation as $accessor => $expectation) {
            $this->assertSame($expectation, $diff->$accessor());
        }
    }
}
