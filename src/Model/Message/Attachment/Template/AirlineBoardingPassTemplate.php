<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message\Attachment\Template;

use Kerox\Messenger\Model\Message\Attachment\Template;

class AirlineBoardingPassTemplate extends AbstractAirlineTemplate
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
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     */
    public function __construct(string $introMessage, string $locale, array $boardingPass)
    {
        parent::__construct($locale);

        $this->introMessage = $introMessage;
        $this->boardingPass = $boardingPass;
    }

    /**
     * @param string $introMessage
     * @param string $locale
     * @param array  $boardingPass
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\AirlineBoardingPassTemplate
     */
    public static function create(string $introMessage, string $locale, array $boardingPass): self
    {
        return new self($introMessage, $locale, $boardingPass);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = parent::toArray();
        $array += [
            'payload' => [
                'template_type' => Template::TYPE_AIRLINE_BOARDINGPASS,
                'intro_message' => $this->introMessage,
                'locale' => $this->locale,
                'theme_color' => $this->themeColor,
                'boarding_pass' => $this->boardingPass,
            ],
        ];

        return $this->arrayFilter($array);
    }
}
