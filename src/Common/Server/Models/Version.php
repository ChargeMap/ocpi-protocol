<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Server\Models;

use JsonSerializable;

class Version implements JsonSerializable
{
    private VersionNumber $versionNumber;

    private string $url;

    public function __construct(VersionNumber $versionNumber, string $url)
    {
        $this->versionNumber = $versionNumber;
        $this->url = $url;
    }

    public function getVersionNumber(): VersionNumber
    {
        return $this->versionNumber;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function jsonSerialize(): array
    {
        return [
            'version' => $this->versionNumber,
            'url' => $this->url
        ];
    }
}
