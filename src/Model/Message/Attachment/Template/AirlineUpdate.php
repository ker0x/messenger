<?php
namespace Kerox\Messenger\Model\Message\Attachment\Template;

use Kerox\Messenger\Model\Message\Attachment\Template;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\FlightInfo;

class AirlineUpdate extends AbstractAirline
{

    const UPDATE_TYPE_DELAY = 'delay';
    const UPDATE_TYPE_GATE_CHANGE = 'gate_change';
    const UPDATE_TYPE_CANCELLATION = 'cancellation';

    /**
     * @var null|string
     */
    protected $introMessage;

    /**
     * @var string
     */
    protected $updateType;

    /**
     * @var string
     */
    protected $pnrNumber;

    /**
     * @var \Kerox\Messenger\Model\Message\Attachment\Template\Airline\FlightInfo
     */
    protected $updateFlightInfo;

    /**
     * AirlineUpdate constructor.
     *
     * @param string $updateType
     * @param string $locale
     * @param string $pnrNumber
     * @param \Kerox\Messenger\Model\Message\Attachment\Template\Airline\FlightInfo $updateFlightInfo
     */
    public function __construct(string $updateType, string $locale, string $pnrNumber, FlightInfo $updateFlightInfo)
    {
        parent::__construct($locale);

        $this->isValidUpdateType($updateType);

        $this->updateType = $updateType;
        $this->pnrNumber = $pnrNumber;
        $this->updateFlightInfo = $updateFlightInfo;
    }

    /**
     * @param string $introMessage
     * @return AirlineUpdate
     */
    public function setIntroMessage($introMessage): AirlineUpdate
    {
        $this->introMessage = $introMessage;

        return $this;
    }

    /**
     * @param string $updateType
     * @return void
     * @throws \InvalidArgumentException
     */
    private function isValidUpdateType(string $updateType)
    {
        $allowedUpdateType = $this->getAllowedUpdateType();
        if (!in_array($updateType, $allowedUpdateType)) {
            throw new \InvalidArgumentException('Allowed values for $updateType are: ' . implode(',', $allowedUpdateType));
        }
    }

    /**
     * @return array
     */
    private function getAllowedUpdateType(): array
    {
        return [
            self::UPDATE_TYPE_DELAY,
            self::UPDATE_TYPE_GATE_CHANGE,
            self::UPDATE_TYPE_CANCELLATION,
        ];
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $payload = [
            'template_type' => Template::TYPE_AIRLINE_UPDATE,
            'intro_message' => $this->introMessage,
            'update_type' => $this->updateType,
            'locale' => $this->locale,
            'pnr_number' => $this->pnrNumber,
            'update_flight_info' => $this->updateFlightInfo,
        ];

        $json = parent::jsonSerialize();
        $json += [
            'payload' => array_filter($payload),
        ];

        return $json;
    }
}
