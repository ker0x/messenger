<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message\Attachment\Template;

use Kerox\Messenger\Helper\ValidatorTrait;
use Kerox\Messenger\Model\Message\Attachment\Template;

abstract class AbstractAirlineTemplate extends Template
{
    use ValidatorTrait;

    /**
     * @var string
     */
    protected $locale;

    /**
     * @var null|string
     */
    protected $themeColor;

    /**
     * AbstractAirline constructor.
     *
     * @param string $locale
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     */
    public function __construct(string $locale)
    {
        parent::__construct();

        $this->isValidLocale($locale);

        $this->locale = $locale;
    }

    /**
     * @param string $themeColor
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\AbstractAirlineTemplate
     */
    public function setThemeColor(string $themeColor): self
    {
        $this->isValidColor($themeColor);

        $this->themeColor = $themeColor;

        return $this;
    }
}
