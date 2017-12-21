<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message\Attachment\Template\Airline;

abstract class AbstractFlightInfo implements \JsonSerializable
{
    /**
     * @var string
     */
    protected $flightNumber;

    /**
     * @var Airport
     */
    protected $departureAirport;

    /**
     * @var Airport
     */
    protected $arrivalAirport;

    /**
     * @var FlightSchedule
     */
    protected $flightSchedule;

    /**
     * AbstractFlightInfo constructor.
     *
     * @param string                                                                    $flightNumber
     * @param \Kerox\Messenger\Model\Message\Attachment\Template\Airline\Airport        $departureAirport
     * @param \Kerox\Messenger\Model\Message\Attachment\Template\Airline\Airport        $arrivalAirport
     * @param \Kerox\Messenger\Model\Message\Attachment\Template\Airline\FlightSchedule $flightSchedule
     */
    public function __construct(
        string $flightNumber,
        Airport $departureAirport,
        Airport $arrivalAirport,
        FlightSchedule $flightSchedule
    ) {
        $this->flightNumber = $flightNumber;
        $this->departureAirport = $departureAirport;
        $this->arrivalAirport = $arrivalAirport;
        $this->flightSchedule = $flightSchedule;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'flight_number'     => $this->flightNumber,
            'departure_airport' => $this->departureAirport,
            'arrival_airport'   => $this->arrivalAirport,
            'flight_schedule'   => $this->flightSchedule,
        ];
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
