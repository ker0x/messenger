<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message\Attachment\Template\Element;

class ProductElement implements \JsonSerializable
{
    /**
     * @var string
     */
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function create(string $id): self
    {
        return new self($id);
    }

    public function toArray(): array
    {
        $array = [
            'id' => $this->id,
        ];

        return array_filter($array);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
