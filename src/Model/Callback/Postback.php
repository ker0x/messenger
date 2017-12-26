<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Callback;

class Postback
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var null|string
     */
    protected $payload;

    /**
     * @var null|\Kerox\Messenger\Model\Callback\Referral
     */
    protected $referral;

    /**
     * Postback constructor.
     *
     * @param string                                   $title
     * @param null|string                              $payload
     * @param \Kerox\Messenger\Model\Callback\Referral $referral
     */
    public function __construct(string $title, ?string $payload = null, ?Referral $referral = null)
    {
        $this->title = $title;
        $this->payload = $payload;
        $this->referral = $referral;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return bool
     */
    public function hasPayload(): bool
    {
        return $this->payload !== null;
    }

    /**
     * @return null|string
     */
    public function getPayload(): ?string
    {
        return $this->payload;
    }

    /**
     * @return bool
     */
    public function hasReferral(): bool
    {
        return $this->referral !== null;
    }

    /**
     * @return null|\Kerox\Messenger\Model\Callback\Referral
     */
    public function getReferral(): ?Referral
    {
        return $this->referral;
    }

    /**
     * @param array $callbackData
     *
     * @return \Kerox\Messenger\Model\Callback\Postback
     */
    public static function create(array $callbackData): self
    {
        $payload = $callbackData['payload'] ?? null;
        $referral = isset($callbackData['referral']) ? Referral::create($callbackData['referral']) : null;

        return new self($callbackData['title'], $payload, $referral);
    }
}
