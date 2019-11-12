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
     */
    public function __construct(string $airportCode, string $city)
    {
        $this->airportCode = $airportCode;
        $this->city = $city;
    }

    /**
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Airline\Airport
     */
    public static function create(string $airportCode, string $city): self
    {
        return new self($airportCode, $city);
    }

    /**
     * @return Airport
     */
    public function setTerminal(string $terminal): self
    {
        $this->terminal = $terminal;

        return $this;
    }

    /**
     * @return Airport
     */
    public function setGate(string $gate): self
    {
        $this->gate = $gate;

        return $this;
    }

    public function toArray(): array
    {
        $array = [
            'airport_code' => $this->airportCode,
            'city' => $this->city,
            'terminal' => $this->terminal,
            'gate' => $this->gate,
        ];

        return array_filter($array);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
