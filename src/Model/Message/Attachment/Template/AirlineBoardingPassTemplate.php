<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message\Attachment\Template;

use Kerox\Messenger\Model\Message\Attachment\AbstractTemplate;

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
     *@throws \Kerox\Messenger\Exception\MessengerException
     *
     *@return \Kerox\Messenger\Model\Message\Attachment\Template\AirlineBoardingPassTemplate
     */
    public static function create(string $introMessage, string $locale, array $boardingPass): self
    {
        return new self($introMessage, $locale, $boardingPass);
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        $array += [
            'payload' => [
                'template_type' => AbstractTemplate::TYPE_AIRLINE_BOARDINGPASS,
                'intro_message' => $this->introMessage,
                'locale' => $this->locale,
                'theme_color' => $this->themeColor,
                'boarding_pass' => $this->boardingPass,
            ],
        ];

        return $this->arrayFilter($array);
    }
}
