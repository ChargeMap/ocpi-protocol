<?php

namespace Tests\Chargemap\OCPI\Common\Server\Errors;

use Chargemap\OCPI\Common\Server\Errors\OcpiError;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiClientErrorStatusCode;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class OcpiErrorTest extends TestCase
{
    public function testShouldConstructWithValidData(): void
    {
        /** @var OcpiError $mock */
        $mock = $this->getMockBuilder(OcpiError::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $reflectedClass = new ReflectionClass(OcpiError::class);
        $reflectedClass->getConstructor()->invoke($mock, OcpiClientErrorStatusCode::ERROR_CLIENT());;

        $this->assertEquals(OcpiClientErrorStatusCode::ERROR_CLIENT, $mock->getCode());
    }
}
