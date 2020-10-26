<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message\Attachment\Template;

use Kerox\Messenger\Model\Message\Attachment\AbstractTemplate;

class AirlineCheckInTemplate extends AbstractAirlineTemplate
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
     * @var \Kerox\Messenger\Model\Message\Attachment\Template\Airline\FlightInfo[]
     */
    protected $flightInfo;

    /**
     * @var string
     */
    protected $checkinUrl;

    /**
     * AirlineCheckIn constructor.
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     */
    public function __construct(
        string $introMessage,
        string $locale,
        string $pnrNumber,
        array $flightInfo,
        string $checkinUrl
    ) {
        parent::__construct($locale);

        $this->introMessage = $introMessage;
        $this->pnrNumber = $pnrNumber;
        $this->flightInfo = $flightInfo;
        $this->checkinUrl = $checkinUrl;
    }

    /**
     *@throws \Kerox\Messenger\Exception\MessengerException
     *
     *@return \Kerox\Messenger\Model\Message\Attachment\Template\AirlineCheckInTemplate
     */
    public static function create(
        string $introMessage,
        string $locale,
        string $pnrNumber,
        array $flightInfo,
        string $checkinUrl
    ): self {
        return new self($introMessage, $locale, $pnrNumber, $flightInfo, $checkinUrl);
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        $array += [
            'payload' => [
                'template_type' => AbstractTemplate::TYPE_AIRLINE_CHECKIN,
                'intro_message' => $this->introMessage,
                'locale' => $this->locale,
                'theme_color' => $this->themeColor,
                'pnr_number' => $this->pnrNumber,
                'flight_info' => $this->flightInfo,
                'checkin_url' => $this->checkinUrl,
            ],
        ];

        return $this->arrayFilter($array);
    }
}
