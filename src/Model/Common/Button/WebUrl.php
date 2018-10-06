<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Common\Button;

use Kerox\Messenger\Exception\InvalidKeyException;

class WebUrl extends AbstractButton
{
    public const RATIO_TYPE_COMPACT = 'compact';
    public const RATIO_TYPE_TALL = 'tall';
    public const RATIO_TYPE_FULL = 'full';

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $webviewHeightRatio;

    /**
     * @var null|bool
     */
    protected $messengerExtension;

    /**
     * @var null|string
     */
    protected $fallbackUrl;

    /**
     * @var null|string
     */
    protected $webviewShareButton;

    /**
     * WebUrl constructor.
     *
     * @param string $title
     * @param string $url
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     */
    public function __construct(string $title, string $url)
    {
        parent::__construct(self::TYPE_WEB_URL);

        $this->isValidString($title, 20);
        $this->isValidUrl($url);

        $this->title = $title;
        $this->url = $url;
    }

    /**
     * @param string $title
     * @param string $url
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return \Kerox\Messenger\Model\Common\Button\WebUrl
     */
    public static function create(string $title, string $url): self
    {
        return new self($title, $url);
    }

    /**
     * @param string $webviewHeightRatio
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return WebUrl
     */
    public function setWebviewHeightRatio(string $webviewHeightRatio): self
    {
        $this->isValidWebviewHeightRatio($webviewHeightRatio);

        $this->webviewHeightRatio = $webviewHeightRatio;

        return $this;
    }

    /**
     * @param bool $messengerExtension
     *
     * @return WebUrl
     */
    public function setMessengerExtension(bool $messengerExtension): self
    {
        $this->messengerExtension = $messengerExtension;

        return $this;
    }

    /**
     * @param string $fallbackUrl
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return WebUrl
     */
    public function setFallbackUrl(string $fallbackUrl): self
    {
        $this->isValidUrl($fallbackUrl);

        $this->fallbackUrl = $fallbackUrl;

        return $this;
    }

    public function setWebviewShareButton(bool $webviewShareButton): self
    {
        if (!$webviewShareButton) {
            $this->webviewShareButton = 'hide';
        }

        return $this;
    }

    /**
     * @param string $webviewHeightRatio
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     */
    private function isValidWebviewHeightRatio(string $webviewHeightRatio): void
    {
        $allowedRatioType = $this->getAllowedRatioType();
        if (!\in_array($webviewHeightRatio, $allowedRatioType, true)) {
            throw new InvalidKeyException(sprintf(
                'webviewHeightRatio must be either "%s".',
                implode(', ', $allowedRatioType)
            ));
        }
    }

    /**
     * @return array
     */
    private function getAllowedRatioType(): array
    {
        return [
            self::RATIO_TYPE_COMPACT,
            self::RATIO_TYPE_TALL,
            self::RATIO_TYPE_FULL,
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = parent::toArray();
        $array += [
            'url' => $this->url,
            'title' => $this->title,
            'webview_height_ratio' => $this->webviewHeightRatio,
            'messenger_extensions' => $this->messengerExtension,
            'fallback_url' => $this->fallbackUrl,
            'webview_share_button' => $this->webviewShareButton,
        ];

        return array_filter($array);
    }
}
