<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\ProfileSettings;

use Kerox\Messenger\Helper\ValidatorTrait;
use Kerox\Messenger\Model\Common\Button\WebUrl;

class HomeUrl implements \JsonSerializable
{
    use ValidatorTrait;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $webviewHeightRation;

    /**
     * @var string
     */
    protected $webviewShareButton;

    /**
     * @var bool
     */
    protected $inTest;

    /**
     * HomeUrl constructor.
     *
     * @throws \Kerox\Messenger\Exception\InvalidUrlException
     */
    public function __construct(
        string $url,
        string $webviewHeightRation = WebUrl::RATIO_TYPE_TALL,
        string $webviewShareButton = 'hide',
        bool $inTest = true
    ) {
        $this->isValidUrl($url);

        $this->url = $url;
        $this->webviewHeightRation = $webviewHeightRation;
        $this->webviewShareButton = $webviewShareButton;
        $this->inTest = $inTest;
    }

    /**
     * @throws \Kerox\Messenger\Exception\InvalidUrlException
     *
     * @return \Kerox\Messenger\Model\ProfileSettings\HomeUrl
     */
    public static function create(
        string $url,
        string $webviewHeightRation = WebUrl::RATIO_TYPE_TALL,
        string $webviewShareButton = 'hide',
        bool $inTest = true
    ): self {
        return new self($url, $webviewHeightRation, $webviewShareButton, $inTest);
    }

    public function toArray(): array
    {
        return [
            'url' => $this->url,
            'webview_height_ration' => $this->webviewHeightRation,
            'webview_share_button' => $this->webviewShareButton,
            'in_test' => $this->inTest,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
