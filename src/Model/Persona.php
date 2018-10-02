<?php

namespace Kerox\Messenger\Model;

use Kerox\Messenger\Helper\ValidatorTrait;

class Persona implements \JsonSerializable
{
    use ValidatorTrait;

    protected $id;

    protected $name;

    protected $profileImageUrl;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->profileImageUrl = $data['profileImageUrl'] ?? null;
    }

    public static function create(array $data): Persona
    {
        return new static($data);
    }

    public function toArray(): array
    {
        $array = [
            'id' => $this->id,
            'name' => $this->name,
            'profileImageUrl' => $this->profileImageUrl,
        ];

        return \array_filter($array);
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
