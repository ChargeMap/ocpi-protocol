<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use JsonSerializable;

class Endpoint implements JsonSerializable
{
    private ModuleId $moduleId;

    private string $url;

    public function __construct(ModuleId $moduleId, string $url)
    {
        $this->moduleId = $moduleId;
        $this->url = $url;
    }

    public function getModuleId(): ModuleId
    {
        return $this->moduleId;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function jsonSerialize(): array
    {
        return [
            'identifier' => $this->moduleId,
            'url' => $this->url,
        ];
    }
}