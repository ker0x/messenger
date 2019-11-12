<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message\Attachment\Template\Airline;

interface TravelClassInterface
{
    public const ECONOMY = 'economy';
    public const BUSINESS = 'business';
    public const FIRST_CLASS = 'first_class';

    /**
     * @throws \Kerox\Messenger\Exception\MessengerException
     */
    public function isValidTravelClass(string $travelClass): void;

    public function getAllowedTravelClass(): array;
}
