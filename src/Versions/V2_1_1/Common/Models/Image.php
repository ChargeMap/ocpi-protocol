<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use JsonSerializable;

class Image implements JsonSerializable
{
    private string $url;

    private ?string $thumbnail;

    private ImageCategory $category;

    private string $type;

    private ?int $width;

    private ?int $height;

    /**
     * Image constructor.
     * @param string $url
     * @param string|null $thumbnail
     * @param ImageCategory $category
     * @param string $type
     * @param int|null $width
     * @param int|null $height
     */
    public function __construct(string $url, ?string $thumbnail, ImageCategory $category, string $type, ?int $width, ?int $height)
    {
        $this->url = $url;
        $this->thumbnail = $thumbnail;
        $this->category = $category;
        $this->type = $type;
        $this->width = $width;
        $this->height = $height;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function getCategory(): ImageCategory
    {
        return $this->category;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'url' => $this->url,
            'category' => $this->category,
            'type' => $this->type,
        ];

        if ($this->thumbnail !== null) {
            $return['thumbnail'] = $this->thumbnail;
        }

        if ($this->width !== null) {
            $return['width'] = $this->width;
        }

        if ($this->height !== null) {
            $return['height'] = $this->height;
        }

        return $return;
    }
}
