<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Tokens\Get;

use Chargemap\OCPI\Common\Server\OcpiListingResponse;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Token;

class OcpiEmspTokenGetResponse extends OcpiListingResponse
{
    /** @var Token[] */
    private array $tokens = [];

    public function addToken(Token $token): self
    {
        $this->tokens[] = $token;
        return $this;
    }

    /**
     * @return Token[]
     */
    public function getData(): array
    {
        return $this->tokens;
    }
}
