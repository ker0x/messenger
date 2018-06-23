<?php

declare(strict_types=1);

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
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(string $departureTime)
    {
        $this->isValidDateTime($departureTime);

        $this->departureTime = $departureTime;
    }

    /**
     * @param string $departureTime
     *
     * @throws \InvalidArgumentException
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Airline\FlightSchedule
     */
    public static function create(string $departureTime): self
    {
        return new self($departureTime);
    }

    /**
     * @param string $boardingTime
     *
     * @throws \InvalidArgumentException
     *
     * @return FlightSchedule
     */
    public function setBoardingTime(string $boardingTime): self
    {
        $this->isValidDateTime($boardingTime);

        $this->boardingTime = $boardingTime;

        return $this;
    }

    /**
     * @param string $arrivalTime
     *
     * @throws \InvalidArgumentException
     *
     * @return FlightSchedule
     */
    public function setArrivalTime(string $arrivalTime): self
    {
        $this->isValidDateTime($arrivalTime);

        $this->arrivalTime = $arrivalTime;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = [
            'boarding_time' => $this->boardingTime,
            'departure_time' => $this->departureTime,
            'arrival_time' => $this->arrivalTime,
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
