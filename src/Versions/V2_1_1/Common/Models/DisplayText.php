<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use JsonSerializable;

class DisplayText implements JsonSerializable
{
    private string $language;

    private string $text;

    public function __construct(string $language, string $text)
    {
        $this->language = $language;
        $this->text = $text;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function jsonSerialize(): array
    {
        return [
            'language' => $this->language,
            'text' => $this->text
        ];
    }
}
