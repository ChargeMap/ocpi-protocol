<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Common\Utils;

use BadMethodCallException;
use PHPUnit\Framework\TestCase;
use stdClass;
use TypeError;

/**
 * @covers \Chargemap\OCPI\Common\Utils\PartialModel
 */
class PartialModelTest extends TestCase
{
    public function testHasMethodsReturnTrueAfterInit(): void
    {
        $partialModel = new ConcretePartialModel();

        self::assertFalse($partialModel->hasNullableProperty());
        self::assertNull($partialModel->getNullableProperty());
        self::assertFalse($partialModel->hasElements());
        self::assertNull($partialModel->getElements());

        $partialModel->withNullableProperty(null);
        self::assertTrue($partialModel->hasNullableProperty());
        self::assertNull($partialModel->getNullableProperty());

        $partialModel->withElements();
        self::assertTrue($partialModel->hasElements());
        self::assertSame([], $partialModel->getElements());
    }

    public function testFailOnInvalidNullableProperty(): void
    {
        $partialModel = new ConcretePartialModel();
        $invalidValue = new stdClass();

        $this->expectException(TypeError::class);
        $partialModel->withNullableProperty($invalidValue);

    }

    public function testFailOnInvalidArrayElement(): void
    {
        $partialModel = new ConcretePartialModel();
        $invalidValue = new stdClass();

        $partialModel->withElements();
        $this->expectException(TypeError::class);
        $partialModel->withElement($invalidValue);
    }

    public function testSetNonNullProperties(): void
    {
        $partialModel = new ConcretePartialModel();
        $value = 'i am a value';

        $partialModel->withNullableProperty($value);
        self::assertTrue($partialModel->hasNullableProperty());
        self::assertSame($value, $partialModel->getNullableProperty());

        $partialModel->withElements();
        self::assertTrue($partialModel->hasElements());
        $partialModel->withElement($value);
        self::assertTrue($partialModel->hasElements());
        self::assertSame([$value], $partialModel->getElements());
    }

    public function testReturnFalseOnNotExistingProperty(): void
    {
        $partialModel = new ConcretePartialModel();

        self::assertFalse($partialModel->hasNotExistingProperty());
    }

    public function testFailsOnNotExistingMethod(): void
    {
        $partialModel = new ConcretePartialModel();

        self::expectException(BadMethodCallException::class);
        $partialModel->method();
    }

    public function testFailsOnNotExistingWithMethod(): void
    {
        $partialModel = new ConcretePartialModel();

        self::expectException(BadMethodCallException::class);
        $partialModel->withSomeProperty();
    }
}
