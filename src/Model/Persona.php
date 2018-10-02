<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model;

use Kerox\Messenger\Helper\ValidatorTrait;

class Persona implements \JsonSerializable
{
    use ValidatorTrait;

    /**
     * @var string|null
     */
    protected $id;

    /**
     * @var string|null
     */
    protected $name;

    /**
     * @var string|null
     */
    protected $profile_picture_url;

    /**
     * Persona constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        foreach ($data as $field => $value) {
            if (property_exists($this, $field)) {
                $this->{$field} = $value;
            }
        }
    }

    /**
     * @param array $data
     *
     * @return Persona
     */
    public static function create(array $data = []): Persona
    {
        return new static($data);
    }

    /**
     * @param string $id
     *
     * @return Persona
     */
    public function setId(string $id): Persona
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return Persona
     */
    public function setName(string $name): Persona
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $url
     *
     * @return Persona
     */
    public function setProfilePictureUrl(string $url): Persona
    {
        $this->isValidUrl($url);

        $this->profile_picture_url = $url;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getProfilePictureUrl(): ?string
    {
        return $this->profile_picture_url;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = [
            'id' => $this->id,
            'name' => $this->name,
            'profile_picture_url' => $this->profile_picture_url,
        ];

        return \array_filter($array);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
