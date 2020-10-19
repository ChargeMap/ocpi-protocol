<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Connectors\Get;

use Chargemap\OCPI\Common\Server\StatusCodes\OcpiSuccessHttpCode;
use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\ConnectorFactory;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Locations\Evses\Connectors\Get\OcpiEmspConnectorGetResponse;
use DateTime;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;

class ResponseConstructionTest extends TestCase
{
    public function testShouldSerializeLocationCorrectlyWithFullPayload()
    {
        $connector = ConnectorFactory::fromJson(json_decode(file_get_contents(__DIR__ . '/payloads/ConnectorPutFullPayload.json')));
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $response = new OcpiEmspConnectorGetResponse($connector);

        $responseInterface = $response->getResponseInterface($responseFactory, $streamFactory);
        $this->assertSame(OcpiSuccessHttpCode::HTTP_OK, $responseInterface->getStatusCode());
        $jsonConnector = json_decode($responseInterface->getBody()->getContents(), true)['data'];
        $this->assertSame('1', $jsonConnector['id']);
        $this->assertSame('IEC_62196_T2', $jsonConnector['standard']);
        $this->assertSame('CABLE', $jsonConnector['format']);
        $this->assertSame('AC_3_PHASE', $jsonConnector['power_type']);
        $this->assertSame(220, $jsonConnector['voltage']);
        $this->assertSame(16, $jsonConnector['amperage']);
        $this->assertSame('11', $jsonConnector['tariff_id']);
        $this->assertSame('https://google.com', $jsonConnector['terms_and_conditions']);
        $this->assertEquals(DateTimeFormatter::format(new DateTime('2015-03-16T10:10:02Z')), $jsonConnector['last_updated']);
    }
}
