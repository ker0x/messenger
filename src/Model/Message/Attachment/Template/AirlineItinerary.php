<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message\Attachment\Template;

use Kerox\Messenger\Model\Message\Attachment\Template;

class AirlineItinerary extends AbstractAirline
{
    /**
     * @var string
     */
    protected $introMessage;

    /**
     * @var string
     */
    protected $pnrNumber;

    /**
     * @var \Kerox\Messenger\Model\Message\Attachment\Template\Airline\PassengerInfo[]
     */
    protected $passengerInfo;

    /**
     * @var \Kerox\Messenger\Model\Message\Attachment\Template\Airline\ExtendedFlightInfo[]
     */
    protected $flightInfo;

    /**
     * @var \Kerox\Messenger\Model\Message\Attachment\Template\Airline\PassengerSegmentInfo[]
     */
    protected $passengerSegmentInfo;

    /**
     * @var array
     */
    protected $priceInfo = [];

    /**
     * @var null|string
     */
    protected $basePrice;

    /**
     * @var null|string
     */
    protected $tax;

    /**
     * @var string
     */
    protected $totalPrice;

    /**
     * @var string
     */
    protected $currency;

    /**
     * AirlineItinerary constructor.
     *
     * @param string                                                                            $introMessage
     * @param string                                                                            $locale
     * @param string                                                                            $pnrNumber
     * @param \Kerox\Messenger\Model\Message\Attachment\Template\Airline\PassengerInfo[]        $passengerInfo
     * @param \Kerox\Messenger\Model\Message\Attachment\Template\Airline\ExtendedFlightInfo[]   $flightInfo
     * @param \Kerox\Messenger\Model\Message\Attachment\Template\Airline\PassengerSegmentInfo[] $passengerSegmentInfo
     * @param string                                                                            $totalPrice
     * @param string                                                                            $currency
     */
    public function __construct(
        string $introMessage,
        string $locale,
        string $pnrNumber,
        array $passengerInfo,
        array $flightInfo,
        array $passengerSegmentInfo,
        string $totalPrice,
        string $currency
    ) {
        parent::__construct($locale);

        $this->introMessage = $introMessage;
        $this->pnrNumber = $pnrNumber;
        $this->passengerInfo = $passengerInfo;
        $this->flightInfo = $flightInfo;
        $this->passengerSegmentInfo = $passengerSegmentInfo;
        $this->totalPrice = $totalPrice;
        $this->currency = $currency;
    }

    /**
     * @param string $title
     * @param string $amount
     * @param string $currency
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\AirlineItinerary
     *
     * @internal param array|null $priceInfo
     */
    public function addPriceInfo(string $title, string $amount, ?string $currency = null): self
    {
        if ($currency !== null) {
            $this->isValidCurrency($currency);
        }

        $priceInfo = [
            'title'    => $title,
            'amount'   => $amount,
            'currency' => $currency,
        ];

        $this->isValidArray($this->priceInfo, 4);

        $this->priceInfo[] = array_filter($priceInfo);

        return $this;
    }

    /**
     * @param string $basePrice
     *
     * @return AirlineItinerary
     */
    public function setBasePrice(string $basePrice): self
    {
        $this->basePrice = $basePrice;

        return $this;
    }

    /**
     * @param string $tax
     *
     * @return AirlineItinerary
     */
    public function setTax(string $tax): self
    {
        $this->tax = $tax;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = parent::jsonSerialize();
        $json += [
            'payload' => [
                'template_type'          => Template::TYPE_AIRLINE_ITINERARY,
                'intro_message'          => $this->introMessage,
                'locale'                 => $this->locale,
                'theme_color'            => $this->themeColor,
                'pnr_number'             => $this->pnrNumber,
                'passenger_info'         => $this->passengerInfo,
                'flight_info'            => $this->flightInfo,
                'passenger_segment_info' => $this->passengerSegmentInfo,
                'price_info'             => $this->priceInfo,
                'base_price'             => $this->basePrice,
                'tax'                    => $this->tax,
                'total_price'            => $this->totalPrice,
                'currency'               => $this->currency,
            ],
        ];

        return $this->arrayFilter($json);
    }
}
