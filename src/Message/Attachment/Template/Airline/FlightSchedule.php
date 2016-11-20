<?php
namespace Kerox\Messenger\Message\Attachment\Template\Airline;

class FlightSchedule implements \JsonSerializable
{

    /**
     * @var null|string
     */
    protected $boardingTime;

    /**
     * @var string
     */
    protected $departureTime;

    /**
     * @var null|string
     */
    protected $arrivalTime;

    /**
     * FlightSchedule constructor.
     *
     * @param string $departureTime
     */
    public function __construct(string $departureTime)
    {
        $this->departureTime = $departureTime;
    }

    /**
     * @param string $boardingTime
     * @return FlightSchedule
     */
    public function setBoardingTime(string $boardingTime): FlightSchedule
    {
        $this->boardingTime = $boardingTime;

        return $this;
    }

    /**
     * @param string $arrivalTime
     * @return FlightSchedule
     */
    public function setArrivalTime(string $arrivalTime): FlightSchedule
    {
        $this->arrivalTime = $arrivalTime;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = [
            'boarding_time' => $this->boardingTime,
            'departure_time' => $this->departureTime,
            'arrival_time' => $this->arrivalTime,
        ];

        return array_filter($json);
    }
}