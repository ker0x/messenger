<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message\Attachment\Template\Airline;

use Kerox\Messenger\Exception\MessengerException;
use Kerox\Messenger\Helper\ValidatorTrait;

class BoardingPass implements \JsonSerializable, TravelClassInterface
{
    use ValidatorTrait;

    /**
     * @var string
     */
    protected $passengerName;

    /**
     * @var string
     */
    protected $pnrNumber;

    /**
     * @var null|string
     */
    protected $travelClass;

    /**
     * @var null|string
     */
    protected $seat;

    /**
     * @var array
     */
    protected $auxiliaryFields = [];

    /**
     * @var array
     */
    protected $secondaryFields = [];

    /**
     * @var string
     */
    protected $logoImageUrl;

    /**
     * @var null|string
     */
    protected $headerImageUrl;

    /**
     * @var null|string
     */
    protected $headerTextField;

    /**
     * @var null|string
     */
    protected $qrCode;

    /**
     * @var null|string
     */
    protected $barcodeImageUrl;

    /**
     * @var string
     */
    protected $aboveBarcodeImageUrl;

    /**
     * @var FlightInfo;
     */
    protected $flightInfo;

    /**
     * BoardingPass constructor.
     *
     * @param string                                                                $passengerName
     * @param string                                                                $pnrNumber
     * @param string                                                                $logoImageUrl
     * @param string                                                                $code
     * @param string                                                                $aboveBarcodeImageUrl
     * @param \Kerox\Messenger\Model\Message\Attachment\Template\Airline\FlightInfo $flightInfo
     */
    public function __construct(
        string $passengerName,
        string $pnrNumber,
        string $logoImageUrl,
        string $code,
        string $aboveBarcodeImageUrl,
        FlightInfo $flightInfo
    ) {
        $this->passengerName = $passengerName;
        $this->pnrNumber = $pnrNumber;
        $this->logoImageUrl = $logoImageUrl;
        $this->aboveBarcodeImageUrl = $aboveBarcodeImageUrl;
        $this->flightInfo = $flightInfo;

        $this->setCode($code);
    }

    /**
     * @param string                                                                $passengerName
     * @param string                                                                $pnrNumber
     * @param string                                                                $logoImageUrl
     * @param string                                                                $code
     * @param string                                                                $aboveBarcodeImageUrl
     * @param \Kerox\Messenger\Model\Message\Attachment\Template\Airline\FlightInfo $flightInfo
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Airline\BoardingPass
     */
    public static function create(
        string $passengerName,
        string $pnrNumber,
        string $logoImageUrl,
        string $code,
        string $aboveBarcodeImageUrl,
        FlightInfo $flightInfo
    ): self {
        return new self($passengerName, $pnrNumber, $logoImageUrl, $code, $aboveBarcodeImageUrl, $flightInfo);
    }

    /**
     * @param string $travelClass
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Airline\BoardingPass
     */
    public function setTravelClass(string $travelClass): self
    {
        $this->isValidTravelClass($travelClass);

        $this->travelClass = $travelClass;

        return $this;
    }

    /**
     * @param string $seat
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Airline\BoardingPass
     */
    public function setSeat(string $seat): self
    {
        $this->seat = $seat;

        return $this;
    }

    /**
     * @param string $label
     * @param string $value
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Airline\BoardingPass
     */
    public function addAuxiliaryFields(string $label, string $value): self
    {
        $this->auxiliaryFields[] = $this->setLabelValue($label, $value);

        $this->isValidArray($this->auxiliaryFields, 5);

        return $this;
    }

    /**
     * @param string $label
     * @param string $value
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Airline\BoardingPass
     */
    public function addSecondaryFields(string $label, string $value): self
    {
        $this->secondaryFields[] = $this->setLabelValue($label, $value);

        $this->isValidArray($this->secondaryFields, 5);

        return $this;
    }

    /**
     * @param string $headerImageUrl
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Airline\BoardingPass
     */
    public function setHeaderImageUrl(string $headerImageUrl): self
    {
        $this->isValidUrl($headerImageUrl);

        $this->headerImageUrl = $headerImageUrl;

        return $this;
    }

    /**
     * @param string $headerTextField
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Airline\BoardingPass
     */
    public function setHeaderTextField(string $headerTextField): self
    {
        $this->headerTextField = $headerTextField;

        return $this;
    }

    /**
     * @param string $label
     * @param string $value
     *
     * @return array
     */
    private function setLabelValue(string $label, string $value): array
    {
        return [
            'label' => $label,
            'value' => $value,
        ];
    }

    /**
     * @param string $code
     */
    private function setCode(string $code): void
    {
        if (filter_var($code, FILTER_VALIDATE_URL)) {
            $this->barcodeImageUrl = $code;

            return;
        }
        $this->qrCode = $code;
    }

    /**
     * @param string $travelClass
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     */
    public function isValidTravelClass(string $travelClass): void
    {
        $allowedTravelClass = $this->getAllowedTravelClass();
        if (!\in_array($travelClass, $allowedTravelClass, true)) {
            throw new MessengerException(sprintf(
                'travelClass must be either "%s".',
                implode(', ', $allowedTravelClass)
            ));
        }
    }

    /**
     * @return array
     */
    public function getAllowedTravelClass(): array
    {
        return [
            self::ECONOMY,
            self::BUSINESS,
            self::FIRST_CLASS,
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = [
            'passenger_name' => $this->passengerName,
            'pnr_number' => $this->pnrNumber,
            'travel_class' => $this->travelClass,
            'seat' => $this->seat,
            'auxiliary_fields' => $this->auxiliaryFields,
            'secondary_fields' => $this->secondaryFields,
            'logo_image_url' => $this->logoImageUrl,
            'header_image_url' => $this->headerImageUrl,
            'header_text_field' => $this->headerTextField,
            'qr_code' => $this->qrCode,
            'barcode_image_url' => $this->barcodeImageUrl,
            'above_bar_code_image_url' => $this->aboveBarcodeImageUrl,
            'flight_info' => $this->flightInfo,
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
