<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

class PhysicalReferenceFactory
{
    public static function fromString(?string $physicalReference): ?string
    {
        return $physicalReference;
    }
}