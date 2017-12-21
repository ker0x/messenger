<?php

declare(strict_types=1);

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
     * @param string $passengerId
     * @param string $name
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Airline\PassengerInfo
     */
    public static function create(string $passengerId, string $name): self
    {
        return new self($passengerId, $name);
    }

    /**
     * @param string $ticketNumber
     *
     * @return PassengerInfo
     */
    public function setTicketNumber(string $ticketNumber): self
    {
        $this->ticketNumber = $ticketNumber;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = [
            'passenger_id'  => $this->passengerId,
            'ticket_number' => $this->ticketNumber,
            'name'          => $this->name,
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
