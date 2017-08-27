<?php

namespace Kerox\Messenger\Model\Message\Attachment\Template;

use Kerox\Messenger\Model\Message\Attachment\Template;

class AirlineBoardingPass extends AbstractAirline
{
    /**
     * @var string
     */
    protected $introMessage;

    /**
     * @var \Kerox\Messenger\Model\Message\Attachment\Template\Airline\BoardingPass[]
     */
    protected $boardingPass;

    /**
     * AirlineBoardingPass constructor.
     *
     * @param string                                                                    $introMessage
     * @param string                                                                    $locale
     * @param \Kerox\Messenger\Model\Message\Attachment\Template\Airline\BoardingPass[] $boardingPass
     */
    public function __construct(string $introMessage, string $locale, array $boardingPass)
    {
        parent::__construct($locale);

        $this->introMessage = $introMessage;
        $this->boardingPass = $boardingPass;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = parent::jsonSerialize();
        $json += [
            'payload' => [
                'template_type' => Template::TYPE_AIRLINE_BOARDINGPASS,
                'intro_message' => $this->introMessage,
                'locale'        => $this->locale,
                'theme_color'   => $this->themeColor,
                'boarding_pass' => $this->boardingPass,
            ]
        ];

        return $this->arrayFilter($json);
    }
}
