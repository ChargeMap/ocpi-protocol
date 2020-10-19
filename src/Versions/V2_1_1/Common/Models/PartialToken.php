<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use DateTime;
use JsonSerializable;

class PartialToken implements JsonSerializable
{
    private ?string $uid;

    private ?TokenType $type;

    private ?string $authId;

    private ?string $visualNumber;

    private ?string $issuer;

    private ?bool $valid;

    private ?WhiteList $whiteList;

    private ?string $language;

    private ?DateTime $lastUpdated;

    public function __construct(
        ?string $uid,
        ?TokenType $type,
        ?string $authId,
        ?string $visualNumber,
        ?string $issuer,
        ?bool $valid,
        ?WhiteList $whiteList,
        ?string $language,
        ?DateTime $lastUpdated
    )
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

    public function getUid(): ?string
    {
        return $this->uid;
    }

    public function getType(): ?TokenType
    {
        return $this->type;
    }

    public function getAuthId(): ?string
    {
        return $this->authId;
    }

    public function getVisualNumber(): ?string
    {
        return $this->visualNumber;
    }

    public function getIssuer(): ?string
    {
        return $this->issuer;
    }

    public function isValid(): ?bool
    {
        return $this->valid;
    }

    public function getWhiteList(): ?WhiteList
    {
        return $this->whiteList;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function getLastUpdated(): ?DateTime
    {
        return $this->lastUpdated;
    }

    public function jsonSerialize(): array
    {
        $return = [];
        
        if($this->uid !== null){
            $return['uid'] = $this->uid;
        }
        
        if($this->type !== null){
            $return['type'] = $this->type;
        }

        if($this->authId !== null){
            $return['auth_id'] = $this->authId;
        }
        
        if($this->issuer !== null){
            $return['issuer'] = $this->issuer;
        }
        
        if($this->valid !== null){
            $return['valid'] = $this->valid;
        }
        if($this->whiteList !== null){
            $return['whitelist'] = $this->whiteList;
        }
        
        if($this->lastUpdated !== null){
            $return['last_updated'] = DateTimeFormatter::format($this->lastUpdated);
        }
        
        if ($this->visualNumber !== null) {
            $return['visual_number'] = $this->visualNumber;
        }

        if ($this->language !== null) {
            $return['language'] = $this->language;
        }

        return $return;
    }
}
