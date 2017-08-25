<?php

namespace Kerox\Messenger\Model\Message\Attachment\Template\Airline;

use Kerox\Messenger\Helper\ValidatorTrait;

class FlightSchedule implements \JsonSerializable
{
    use ValidatorTrait;

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
        $this->isValidDateTime($departureTime);

        $this->departureTime = $departureTime;
    }

    /**
     * @param string $boardingTime
     *
     * @return FlightSchedule
     */
    public function setBoardingTime(string $boardingTime): FlightSchedule
    {
        $this->isValidDateTime($boardingTime);

        $this->boardingTime = $boardingTime;

        return $this;
    }

    /**
     * @param string $arrivalTime
     *
     * @return FlightSchedule
     */
    public function setArrivalTime(string $arrivalTime): FlightSchedule
    {
        $this->isValidDateTime($arrivalTime);

        $this->arrivalTime = $arrivalTime;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = [
            'boarding_time'  => $this->boardingTime,
            'departure_time' => $this->departureTime,
            'arrival_time'   => $this->arrivalTime,
        ];

        return array_filter($json);
    }
}
