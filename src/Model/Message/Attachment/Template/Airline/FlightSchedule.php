<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message\Attachment\Template\Airline;

use Kerox\Messenger\Helper\ValidatorTrait;

class FlightSchedule implements \JsonSerializable
{
    use ValidatorTrait;

    /**
     * @var string|null
     */
    protected $boardingTime;

    /**
     * @var string
     */
    protected $departureTime;

    /**
     * @var string|null
     */
    protected $arrivalTime;

    /**
     * FlightSchedule constructor.
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     */
    public function __construct(string $departureTime)
    {
        $this->isValidDateTime($departureTime);

        $this->departureTime = $departureTime;
    }

    /**
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Airline\FlightSchedule
     */
    public static function create(string $departureTime): self
    {
        return new self($departureTime);
    }

    /**
     * @throws \Kerox\Messenger\Exception\MessengerException
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
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return FlightSchedule
     */
    public function setArrivalTime(string $arrivalTime): self
    {
        $this->isValidDateTime($arrivalTime);

        $this->arrivalTime = $arrivalTime;

        return $this;
    }

    public function toArray(): array
    {
        $array = [
            'boarding_time' => $this->boardingTime,
            'departure_time' => $this->departureTime,
            'arrival_time' => $this->arrivalTime,
        ];

        return array_filter($array);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
