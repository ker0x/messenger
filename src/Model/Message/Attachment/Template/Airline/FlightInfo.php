<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message\Attachment\Template\Airline;

class FlightInfo extends AbstractFlightInfo
{
    /**
     * @param string                                                                    $flightNumber
     * @param \Kerox\Messenger\Model\Message\Attachment\Template\Airline\Airport        $departureAirport
     * @param \Kerox\Messenger\Model\Message\Attachment\Template\Airline\Airport        $arrivalAirport
     * @param \Kerox\Messenger\Model\Message\Attachment\Template\Airline\FlightSchedule $flightSchedule
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Airline\FlightInfo
     */
    public static function create(
        string $flightNumber,
        Airport $departureAirport,
        Airport $arrivalAirport,
        FlightSchedule $flightSchedule
    ): self {
        return new self($flightNumber, $departureAirport, $arrivalAirport, $flightSchedule);
    }
}
