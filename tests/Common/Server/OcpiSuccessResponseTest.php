<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Common\Server;

use Chargemap\OCPI\Common\Server\OcpiBaseResponse;
use Chargemap\OCPI\Common\Server\OcpiSuccessResponse;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiSuccessHttpCode;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiSuccessStatusCode;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class OcpiSuccessResponseTest extends TestCase
{
    public function testShouldSerializeCorrectly()
    {
        $mock = $this->getMockBuilder(OcpiSuccessResponse::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $reflectedClass = new ReflectionClass(OcpiSuccessResponse::class);
        $constructor = $reflectedClass->getConstructor();
        $constructor->invoke($mock, OcpiSuccessHttpCode::HTTP_OK(), 'Message!');
        $mock->method('getData')->willReturn(null);

        /** @var OcpiBaseResponse $mock */
        $this->assertEquals(OcpiSuccessStatusCode::SUCCESS(), $mock->jsonSerialize()['status_code']);
        $this->assertEquals('Message!', $mock->jsonSerialize()['status_message']);
        $responseInterface = $mock->getResponseInterface();

        $this->assertEquals(OcpiSuccessHttpCode::HTTP_OK, $responseInterface->getStatusCode());
    }


    public function testShouldFailWithIncorrectData(): void
    {
        /** @var OcpiBaseResponse|MockObject $mock */
        $mock = $this->getMockBuilder(OcpiSuccessResponse::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $reflectedClass = new ReflectionClass(OcpiSuccessResponse::class);
        $constructor = $reflectedClass->getConstructor();
        $constructor->invoke($mock, OcpiSuccessHttpCode::HTTP_OK(), 'Message!');
        $mock->method('getData')->willReturn(5);

        $this->expectException(InvalidArgumentException::class);
        $mock->jsonSerialize();
    }
}
