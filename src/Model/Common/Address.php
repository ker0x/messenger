<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Common;

class Address implements \JsonSerializable
{
    /**
     * @var string|null
     */
    protected $name;

    /**
     * @var string
     */
    protected $street;

    /**
     * @var string|null
     */
    protected $additionalStreet;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var string
     */
    protected $postalCode;

    /**
     * @var string
     */
    protected $state;

    /**
     * @var string
     */
    protected $country;

    /**
     * @var int|null
     */
    protected $id;

    /**
     * Address constructor.
     */
    public function __construct(
        string $street,
        string $city,
        string $postalCode,
        string $state,
        string $country
    ) {
        $this->street = $street;
        $this->city = $city;
        $this->postalCode = $postalCode;
        $this->state = $state;
        $this->country = $country;
    }

    /**
     * @return \Kerox\Messenger\Model\Common\Address
     */
    public static function create(
        string $street,
        string $city,
        string $postalCode,
        string $state,
        string $country
    ): self {
        return new self($street, $city, $postalCode, $state, $country);
    }

    /**
     * @return \Kerox\Messenger\Model\Common\Address
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @return Address
     */
    public function setAdditionalStreet(string $additionalStreet): self
    {
        $this->additionalStreet = $additionalStreet;

        return $this;
    }

    public function getAdditionalStreet(): ?string
    {
        return $this->additionalStreet;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @return Address
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function toArray(): array
    {
        $array = [
            'name' => $this->name,
            'street_1' => $this->street,
            'street_2' => $this->additionalStreet,
            'city' => $this->city,
            'postal_code' => $this->postalCode,
            'state' => $this->state,
            'country' => $this->country,
            'id' => $this->id,
        ];

        return array_filter($array);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * @return \Kerox\Messenger\Model\Common\Address
     */
    public static function fromPayload(array $payload): self
    {
        $address = self::create(
            $payload['street_1'],
            $payload['city'],
            $payload['postal_code'],
            $payload['state'],
            $payload['country']
        );

        if (isset($payload['street_2'])) {
            $address->setAdditionalStreet($payload['street_2']);
        }

        if (isset($payload['id'])) {
            $address->setId($payload['id']);
        }

        if (isset($payload['name'])) {
            $address->setName($payload['name']);
        }

        return $address;
    }
}
