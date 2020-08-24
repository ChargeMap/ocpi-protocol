<?php

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use DateTime;
use JsonSerializable;

class Token implements JsonSerializable
{
    private string $uid;

    private TokenType $type;

    private string $authId;

    private ?string $visualNumber;

    private string $issuer;

    private bool $valid;

    private WhiteList $whiteList;

    private ?string $language;

    private DateTime $lastUpdated;

    public function __construct(string $uid, TokenType $type, string $authId, ?string $visualNumber, string $issuer, bool $valid, WhiteList $whiteList, ?string $language, DateTime $lastUpdated)
    {
        $this->uid = $uid;
        $this->type = $type;
        $this->authId = $authId;
        $this->visualNumber = $visualNumber;
        $this->issuer = $issuer;
        $this->valid = $valid;
        $this->whiteList = $whiteList;
        $this->language = $language;
        $this->lastUpdated = $lastUpdated;
    }

    public function getUid(): string
    {
        return $this->uid;
    }

    public function getType(): TokenType
    {
        return $this->type;
    }

    public function getAuthId(): string
    {
        return $this->authId;
    }

    public function getVisualNumber(): ?string
    {
        return $this->visualNumber;
    }

    public function getIssuer(): string
    {
        return $this->issuer;
    }

    public function isValid(): bool
    {
        return $this->valid;
    }

    public function getWhiteList(): WhiteList
    {
        return $this->whiteList;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function getLastUpdated(): DateTime
    {
        return $this->lastUpdated;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'uid' => $this->uid,
            'type' => $this->type,
            'auth_id' => $this->authId,
            'issuer' => $this->issuer,
            'valid' => $this->valid,
            'whitelist' => $this->whiteList,
            'last_updated' => DateTimeFormatter::format($this->lastUpdated)
        ];

        if ($this->visualNumber !== null) {
            $return['visual_number'] = $this->visualNumber;
        }

        if ($this->language !== null) {
            $return['language'] = $this->language;
        }

        return $return;
    }
}
