<?php
namespace Kerox\Messenger\Message\Attachment\Template\Airline;

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
     * @param string $terminal
     * @return Airport
     */
    public function setTerminal(string $terminal): Airport
    {
        $this->terminal = $terminal;

        return $this;
    }

    /**
     * @param string $gate
     * @return Airport
     */
    public function setGate(string $gate): Airport
    {
        $this->gate = $gate;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = [
            'airport_code' => $this->airportCode,
            'city' => $this->city,
            'terminal' => $this->terminal,
            'gate' => $this->gate,
        ];

        return array_filter($json);
    }
}