<?php

namespace Chargemap\OCPI\Common\Client\Modules;

trait ListingRequest
{
    private ?int $offset;

    private ?int $limit;

    public function withOffset(int $offset): self
    {
        $this->offset = $offset;
        return $this;
    }

    public function withLimit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    public function nextOffset(int $totalCount): ?int
    {
        if (($this->limit !== null && $this->offset !== null) && (($nextOffset = $this->limit + $this->offset) < $totalCount)) {
            return $nextOffset;
        }

        return null;
    }

    public function previousOffset(): ?int
    {
        if (($this->limit !== null && $this->offset !== null) && $this->offset > 0) {
            return max(0, $this->offset - $this->limit);
        }

        return null;
    }
}
