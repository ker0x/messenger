<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Common;

class Address implements \JsonSerializable
{
    /**
     * @var null|string
     */
    protected $name;

    /**
     * @var string
     */
    protected $street;

    /**
     * @var null|string
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
     * @var null|int
     */
    protected $id;

    /**
     * Address constructor.
     *
     * @param string $street
     * @param string $city
     * @param string $postalCode
     * @param string $state
     * @param string $country
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
     * @param string $name
     *
     * @return \Kerox\Messenger\Model\Common\Address
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @param string $additionalStreet
     *
     * @return Address
     */
    public function setAdditionalStreet(string $additionalStreet): self
    {
        $this->additionalStreet = $additionalStreet;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getAdditionalStreet(): ?string
    {
        return $this->additionalStreet;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param int $id
     *
     * @return Address
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return null|int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = [
            'name'        => $this->name,
            'street_1'    => $this->street,
            'street_2'    => $this->additionalStreet,
            'city'        => $this->city,
            'postal_code' => $this->postalCode,
            'state'       => $this->state,
            'country'     => $this->country,
            'id'          => $this->id,
        ];

        return array_filter($json);
    }

    /**
     * @param array $payload
     *
     * @return static
     */
    public static function create(array $payload)
    {
        $address = new static(
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
