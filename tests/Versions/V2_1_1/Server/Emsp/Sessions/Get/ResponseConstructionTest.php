<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Get;

use Chargemap\OCPI\Common\Server\StatusCodes\OcpiSuccessHttpCode;
use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\SessionFactory;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Sessions\Get\OcpiEmspSessionGetResponse;
use DateTime;
use PHPUnit\Framework\TestCase;

class ResponseConstructionTest extends TestCase
{
    public function testShouldSerializeSessionCorrectlyWithFullPayload(): void
    {
        $location = SessionFactory::fromJson(json_decode(file_get_contents(__DIR__ . '/payloads/SessionPutFullPayload.json')));
        $response = new OcpiEmspSessionGetResponse($location);
        $responseInterface = $response->getResponseInterface();
        $this->assertSame(OcpiSuccessHttpCode::HTTP_OK, $responseInterface->getStatusCode());

        $jsonSession = json_decode($responseInterface->getBody()->getContents(), true)['data'];
        $this->assertSame('101', $jsonSession['id']);
        $this->assertSame(DateTimeFormatter::format((new DateTime('2015-06-29T22:39:09Z'))), $jsonSession['start_datetime']);
        $this->assertEquals(0.00, $jsonSession['kwh']);
        $this->assertSame('DE8ACC12E46L89', $jsonSession['auth_id']);
        $this->assertSame('AUTH_REQUEST', $jsonSession['auth_method']);
        $this->assertNotEmpty($jsonSession['location']);
        $this->assertSame('random id', $jsonSession['meter_id']);
        $this->assertSame('EUR', $jsonSession['currency']);
        $this->assertCount(2, $jsonSession['charging_periods']);
        $this->assertEquals(2.50, $jsonSession['total_cost']);
        $this->assertSame('PENDING', $jsonSession['status']);
        $this->assertSame(DateTimeFormatter::format((new DateTime('2015-06-29T22:39:09Z'))), $jsonSession['last_updated']);
    }
}
