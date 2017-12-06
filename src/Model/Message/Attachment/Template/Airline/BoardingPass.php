<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message\Attachment\Template\Airline;

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
     * @param string $travelClass
     *
     * @return BoardingPass
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
     * @return BoardingPass
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
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Airline\BoardingPass
     *
     * @internal param array|null $auxiliaryFields
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
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Airline\BoardingPass
     *
     * @internal param array|null $secondaryFields
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
     * @return BoardingPass
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
     * @return BoardingPass
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
     * @throws \InvalidArgumentException
     */
    public function isValidTravelClass(string $travelClass): void
    {
        $allowedTravelClass = $this->getAllowedTravelClass();
        if (!in_array($travelClass, $allowedTravelClass, true)) {
            throw new \InvalidArgumentException('$travelClass must be either ' . implode(', ', $allowedTravelClass));
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
    public function jsonSerialize(): array
    {
        $json = [
            'passenger_name'           => $this->passengerName,
            'pnr_number'               => $this->pnrNumber,
            'travel_class'             => $this->travelClass,
            'seat'                     => $this->seat,
            'auxiliary_fields'         => $this->auxiliaryFields,
            'secondary_fields'         => $this->secondaryFields,
            'logo_image_url'           => $this->logoImageUrl,
            'header_image_url'         => $this->headerImageUrl,
            'header_text_field'        => $this->headerTextField,
            'qr_code'                  => $this->qrCode,
            'barcode_image_url'        => $this->barcodeImageUrl,
            'above_bar_code_image_url' => $this->aboveBarcodeImageUrl,
            'flight_info'              => $this->flightInfo,
        ];

        return array_filter($json);
    }
}
