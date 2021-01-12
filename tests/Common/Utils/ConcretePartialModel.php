<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Common\Utils;

use Chargemap\OCPI\Common\Utils\PartialModel;

/**
 * @method bool hasNullableProperty()
 * @method bool hasElements()
 * @method self withElements()
 * @method self withNullableProperty(?string $property)
 */
class ConcretePartialModel extends PartialModel
{
    private string $normalProperty;
    private ?string $nullableProperty = null;
    /** @var string[]|null */
    private ?array $arrayProperty = null;

    protected function _withNullableProperty(?string $property): self
    {
        $this->nullableProperty = $property;
        return $this;
    }

    public function getNullableProperty(): ?string
    {
        return $this->nullableProperty;
    }

    protected function _withElements(): self
    {
        $this->arrayProperty = [];
        return $this;
    }

    public function withElement(string $element): self
    {
        $this->arrayProperty[] = $element;
        return $this;
    }

    /**
     * @return string[]|null
     */
    public function getElements(): ?array
    {
        return $this->arrayProperty;
    }

    public function withNormalProperty(string $property): self
    {
        $this->normalProperty = $property;
        return $this;
    }

    public function getNormalProperty(): string
    {
        return $this->normalProperty;
    }
}
