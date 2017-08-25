<?php

namespace Kerox\Messenger\Model\Message\Attachment\Template;

use Kerox\Messenger\Model\Message\Attachment\Template;

class AirlineCheckIn extends AbstractAirline
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
     * @param string $introMessage
     * @param string $locale
     * @param string $pnrNumber
     * @param array  $flightInfo
     * @param string $checkinUrl
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
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = parent::jsonSerialize();
        $json += [
            'payload' => [
                'template_type' => Template::TYPE_AIRLINE_CHECKIN,
                'intro_message' => $this->introMessage,
                'locale'        => $this->locale,
                'theme_color'   => $this->themeColor,
                'pnr_number'    => $this->pnrNumber,
                'flight_info'   => $this->flightInfo,
                'checkin_url'   => $this->checkinUrl,
            ],
        ];

        return $this->arrayFilter($json);
    }
}
