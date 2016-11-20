<?php
/**
 * Created by PhpStorm.
 * User: rmo
 * Date: 13/11/2016
 * Time: 01:58
 */

namespace Kerox\Messenger\Message\Attachment\Template\Receipt;


class Address implements \JsonSerializable
{

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
     * Address constructor.
     *
     * @param string $street
     * @param string $city
     * @param string $postalCode
     * @param string $state
     * @param string $country
     */
    public function __construct(string $street,
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
     * @param string $additionalStreet
     * @return Address
     */
    public function setAdditionalStreet(string $additionalStreet): Address
    {
        $this->additionalStreet = $additionalStreet;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = [
            'street_1' => $this->street,
            'street_2' => $this->additionalStreet,
            'city' => $this->city,
            'postal_code' => $this->postalCode,
            'state' => $this->state,
            'country' => $this->country,
        ];

        return array_filter($json);
    }
}
