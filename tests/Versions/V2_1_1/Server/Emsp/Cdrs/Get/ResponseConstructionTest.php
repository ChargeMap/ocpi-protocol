<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Cdrs\Get;

use Chargemap\OCPI\Common\Server\StatusCodes\OcpiSuccessHttpCode;
use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Cdrs\Get\OcpiEmspCdrGetResponse;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\CdrFactory;
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
        $this->assertSame(OcpiSuccessHttpCode::HTTP_OK, $responseInterface->getStatusCode());
        $jsonCdr = json_decode($responseInterface->getBody()->getContents(), true)['data'];
        $this->assertSame('12345', $jsonCdr['id']);
        $this->assertSame(DateTimeFormatter::format(new DateTime('2015-06-29T21:39:09Z')), $jsonCdr['start_date_time']);
        $this->assertSame(DateTimeFormatter::format(new DateTime('2015-06-29T23:37:32Z')), $jsonCdr['stop_date_time']);
        $this->assertSame('DE8ACC12E46L89', $jsonCdr['auth_id']);
        $this->assertSame('WHITELIST', $jsonCdr['auth_method']);
        $this->assertSame('EUR', $jsonCdr['currency']);
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
                            ],
                        ],
                    ],
                ],
                'last_updated' => DateTimeFormatter::format(new DateTime('2015-02-02T14:15:01Z')),
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
                            ],
                        ],
                    ],
                ],
                'last_updated' => DateTimeFormatter::format(new DateTime('2015-02-02T14:15:01Z')),
            ]
        ], $jsonCdr['tariffs']);
        $this->assertEquals([
            [
                'start_date_time' => DateTimeFormatter::format(new DateTime('2015-06-29T21:39:09Z')),
                'dimensions' => [
                    [
                        'type' => 'TIME',
                        'volume' => 1.973
                    ],
                ],
            ],
        ], $jsonCdr['charging_periods']);
        $this->assertSame(4, $jsonCdr['total_cost']);
        $this->assertSame(15.342, $jsonCdr['total_energy']);
        $this->assertSame(1.973, $jsonCdr['total_time']);
        $this->assertEquals(DateTimeFormatter::format(new DateTime('2015-06-29T22:01:13Z')), $jsonCdr['last_updated']);
    }
}
