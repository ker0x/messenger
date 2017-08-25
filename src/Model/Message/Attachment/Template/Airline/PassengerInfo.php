<?php

namespace Kerox\Messenger\Model\Message\Attachment\Template\Airline;

class PassengerInfo implements \JsonSerializable
{
    /**
     * @var string
     */
    protected $passengerId;

    /**
     * @var null|string
     */
    protected $ticketNumber;

    /**
     * @var string
     */
    protected $name;

    /**
     * PassengerInfo constructor.
     *
     * @param string $passengerId
     * @param string $name
     */
    public function __construct(string $passengerId, string $name)
    {
        $this->passengerId = $passengerId;
        $this->name = $name;
    }

    /**
     * @param string $ticketNumber
     *
     * @return PassengerInfo
     */
    public function setTicketNumber(string $ticketNumber): PassengerInfo
    {
        $this->ticketNumber = $ticketNumber;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = [
            'passenger_id'  => $this->passengerId,
            'ticket_number' => $this->ticketNumber,
            'name'          => $this->name,
        ];

        return array_filter($json);
    }
}
