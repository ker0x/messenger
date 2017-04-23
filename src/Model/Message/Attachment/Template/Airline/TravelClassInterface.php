<?php

namespace Kerox\Messenger\Model\Message\Attachment\Template\Airline;

interface TravelClassInterface
{

    const ECONOMY = 'economy';
    const BUSINESS = 'business';
    const FIRST_CLASS = 'first_class';

    /**
     * @param string $travelClass
     * @return string
     */
    public function isValidTravelClass(string $travelClass);

    /**
     * @return array
     */
    public function getAllowedTravelClass(): array;
}
