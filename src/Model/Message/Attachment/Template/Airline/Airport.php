<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message\Attachment\Template\Airline;

class Airport implements \JsonSerializable
{
    /**
     * @var string
     */
    protected $airportCode;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var string
     */
    protected $terminal;

    /**
     * @var string
     */
    protected $gate;

    /**
     * Airport constructor.
     *
     * @param string $airportCode
     * @param string $city
     */
    public function __construct(string $airportCode, string $city)
    {
        $this->airportCode = $airportCode;
        $this->city = $city;
    }

    /**
     * @param string $airportCode
     * @param string $city
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Airline\Airport
     */
    public static function create(string $airportCode, string $city): self
    {
        return new self($airportCode, $city);
    }

    /**
     * @param string $terminal
     *
     * @return Airport
     */
    public function setTerminal(string $terminal): self
    {
        $this->terminal = $terminal;

        return $this;
    }

    /**
     * @param string $gate
     *
     * @return Airport
     */
    public function setGate(string $gate): self
    {
        $this->gate = $gate;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = [
            'airport_code' => $this->airportCode,
            'city'         => $this->city,
            'terminal'     => $this->terminal,
            'gate'         => $this->gate,
        ];

        return array_filter($array);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
