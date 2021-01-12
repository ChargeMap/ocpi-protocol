<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Tokens\Post;

use Chargemap\OCPI\Common\Server\OcpiCreateResponse;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\AllowedType;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\DisplayText;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\LocationReferences;

class OcpiEmspTokenPostResponse extends OcpiCreateResponse
{
    private AllowedType $allowed;

    private ?LocationReferences $location;

    private ?DisplayText $info;

    public function __construct(
        AllowedType $allowed,
        ?LocationReferences $location,
        ?DisplayText $info,
        string $statusMessage = 'Token successfully created.'
    ) {
        parent::__construct($statusMessage);
        $this->allowed = $allowed;
        $this->location = $location;
        $this->info = $info;
    }

    public function getAllowedType(): AllowedType
    {
        return $this->allowed;
    }

    public function getLocationReferences(): ?LocationReferences
    {
        return $this->location;
    }

    public function getInfo(): ?DisplayText
    {
        return $this->info;
    }

    public function getData(): array
    {
        return [
            'allowed' => $this->allowed,
            'location' => $this->location,
            'info' => $this->info
        ];
    }
}
