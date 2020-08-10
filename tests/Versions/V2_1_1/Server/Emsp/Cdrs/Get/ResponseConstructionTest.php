<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Cdrs\Get;

use Chargemap\OCPI\Common\Server\StatusCodes\OcpiSuccessHttpCode;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\CdrFactory;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Cdrs\Get\OcpiEmspCdrGetResponse;
use DateTime;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;

class ResponseConstructionTest extends TestCase
{
    public function testShouldSerializeCdrCorrectlyWithFullPayload()
    {
        $cdr = CdrFactory::fromJson(json_decode(file_get_contents(__DIR__ . '/payloads/CdrFullPayload.json')));
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $response = new OcpiEmspCdrGetResponse($cdr);

        $responseInterface = $response->getResponseInterface($responseFactory, $streamFactory);
        $this->assertEquals(OcpiSuccessHttpCode::HTTP_OK, $responseInterface->getStatusCode());
        $jsonCdr = json_decode($responseInterface->getBody()->getContents(), true)['data'];
        $this->assertEquals('12345', $jsonCdr['id']);
        $this->assertEquals((new DateTime('2015-06-29T21:39:09Z'))->format(DateTime::ISO8601), $jsonCdr['start_date_time']);
        $this->assertEquals((new DateTime('2015-06-29T23:37:32Z'))->format(DateTime::ISO8601), $jsonCdr['stop_date_time']);
        $this->assertEquals('DE8ACC12E46L89', $jsonCdr['auth_id']);
        $this->assertEquals('WHITELIST', $jsonCdr['auth_method']);
        $this->assertEquals('EUR', $jsonCdr['currency']);
        $this->assertEquals([
            [
                'id' => '12',
                'currency' => 'EUR',
                'tariff_alt_text' => [
                    [
                        'language' => 'FR',
                        'text' => 'Chere'
                    ]
                ],
                'tariff_alt_url' => 'https://google.com',
                'elements' => [
                    [
                        'price_components' => [
                            [
                                'type' => 'TIME',
                                'price' => 2.00,
                                'step_size' => 300
                            ]
                        ],
                        'restrictions' => [
                            'start_time' => '09:00',
                            'end_time' => '20:00',
                            'start_date' => '2020-01-09',
                            'end_date' => '2020-02-09',
                            'min_kwh' => 5.5,
                            'max_kwh' => 10.4,
                            'min_power' => 3.3,
                            'max_power' => 5.6,
                            'min_duration' => 1,
                            'max_duration' => 2,
                            'day_of_week' => [
                                'MONDAY',
                                'TUESDAY',
                                'WEDNESDAY'
                            ]
                        ]
                    ],
                    [
                        'price_components' => [
                            [
                                'type' => 'TIME',
                                'price' => 2.00,
                                'step_size' => 300
                            ]
                        ],
                        'restrictions' => null,
                    ]
                ],
                'last_updated' => (new DateTime('2015-02-02T14:15:01Z'))->format(DateTime::ISO8601),
            ],
            [
                'id' => '12',
                'currency' => 'EUR',
                'elements' => [
                    [
                        'price_components' => [
                            [
                                'type' => 'TIME',
                                'price' => 2.00,
                                'step_size' => 300
                            ]
                        ],
                        'restrictions' => null,
                    ]
                ],
                'last_updated' => (new DateTime('2015-02-02T14:15:01Z'))->format(DateTime::ISO8601),
                'tariff_alt_text' => []
            ]
        ], $jsonCdr['tariffs']);
        $this->assertEquals([
            [
                'start_date_time' => (new DateTime('2015-06-29T21:39:09Z'))->format(DateTime::ISO8601),
                'dimensions' => [
                    'TIME' => [
                        'type' => 'TIME',
                        'volume' => 1.973
                    ]
                ]
            ]
        ], $jsonCdr['charging_periods']);
        $this->assertEquals(4, $jsonCdr['total_cost']);
        $this->assertEquals(15.342, $jsonCdr['total_energy']);
        $this->assertEquals(1.973, $jsonCdr['total_time']);
        $this->assertEquals((new DateTime('2015-06-29T22:01:13Z'))->format(DateTime::ISO8601), $jsonCdr['last_updated']);
    }
}
