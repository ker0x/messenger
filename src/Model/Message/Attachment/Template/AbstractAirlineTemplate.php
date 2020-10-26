<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message\Attachment\Template;

use Kerox\Messenger\Helper\ValidatorTrait;
use Kerox\Messenger\Model\Message\Attachment\AbstractTemplate;

abstract class AbstractAirlineTemplate extends AbstractTemplate
{
    use ValidatorTrait;

    /**
     * @var string
     */
    protected $locale;

    /**
     * @var string|null
     */
    protected $themeColor;

    /**
     * AbstractAirline constructor.
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
     *@throws \Kerox\Messenger\Exception\MessengerException
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
