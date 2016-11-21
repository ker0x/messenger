<?php
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
     * @var null|float
     */
    protected $basePrice;

    /**
     * @var null|float
     */
    protected $tax;

    /**
     * @var float
     */
    protected $totalPrice;

    /**
     * @var string
     */
    protected $currency;

    /**
     * AirlineItinerary constructor.
     *
     * @param string $introMessage
     * @param string $locale
     * @param string $pnrNumber
     * @param \Kerox\Messenger\Model\Message\Attachment\Template\Airline\PassengerInfo[] $passengerInfo
     * @param \Kerox\Messenger\Model\Message\Attachment\Template\Airline\ExtendedFlightInfo[] $flightInfo
     * @param \Kerox\Messenger\Model\Message\Attachment\Template\Airline\PassengerSegmentInfo[] $passengerSegmentInfo
     * @param float $totalPrice
     * @param string $currency
     */
    public function __construct(string $introMessage,
                                string $locale,
                                string $pnrNumber,
                                array $passengerInfo,
                                array $flightInfo,
                                array $passengerSegmentInfo,
                                float $totalPrice,
                                string $currency
    ) {
        parent::__construct($locale);

        $this->introMessage = $introMessage;
        $this->pnrNumber = $pnrNumber;
        $this->passengerInfo = $passengerInfo;
        $this->flightInfo = $flightInfo;
        $this->passengerSegmentInfo = $passengerSegmentInfo;
        $this->totalPrice = (string)$totalPrice;
        $this->currency = $currency;
    }

    /**
     * @param string $title
     * @param float $amount
     * @param string $currency
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\AirlineItinerary
     * @internal param array|null $priceInfo
     */
    public function addPriceInfo(string $title, float $amount, string $currency = null): AirlineItinerary
    {
        if ($currency !== null) {
            $this->isValidCurrency($currency);
        }

        $priceInfo = [
            'title' => $title,
            'amount' => $amount,
            'currency' => $currency,
        ];

        $this->isValidArray($this->priceInfo, 4);
        $this->priceInfo[] = array_filter($priceInfo);

        return $this;
    }

    /**
     * @param float $basePrice
     * @return AirlineItinerary
     */
    public function setBasePrice(float $basePrice): AirlineItinerary
    {
        $this->basePrice = (string)$basePrice;

        return $this;
    }

    /**
     * @param float $tax
     * @return AirlineItinerary
     */
    public function setTax(float $tax): AirlineItinerary
    {
        $this->tax = (string)$tax;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $payload = [
            'template_type' => Template::TYPE_AIRLINE_ITINERARY,
            'intro_message' => $this->introMessage,
            'locale' => $this->locale,
            'theme_color' => $this->themeColor,
            'pnr_number' => $this->pnrNumber,
            'passenger_info' => $this->passengerInfo,
            'flight_info' => $this->flightInfo,
            'passenger_segment_info' => $this->passengerSegmentInfo,
            'price_info' => $this->priceInfo,
            'base_price' => $this->basePrice,
            'tax' => $this->tax,
            'total_price' => $this->totalPrice,
            'currency' => $this->currency,
        ];

        $json = parent::jsonSerialize();
        $json += [
            'payload' => array_filter($payload),
        ];

        return $json;
    }
}
