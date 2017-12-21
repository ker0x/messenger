<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model;

class Referral
{
    /**
     * @var string
     */
    protected $source;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $adId;

    /**
     * @var null|string
     */
    protected $ref;

    /**
     * Referral constructor.
     *
     * @param string $source
     * @param string $type
     * @param string $adId
     */
    public function __construct(string $source, string $type, string $adId)
    {
        $this->source = $source;
        $this->type = $type;
        $this->adId = $adId;
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getAdId(): string
    {
        return $this->adId;
    }

    /**
     * @return null|string
     */
    public function getRef(): ?string
    {
        return $this->ref;
    }

    /**
     * @param string $ref
     *
     * @return \Kerox\Messenger\Model\Referral
     */
    public function setRef(string $ref): self
    {
        $this->ref = $ref;

        return $this;
    }

    /**
     * @param array $referral
     *
     * @return \Kerox\Messenger\Model\Referral
     */
    public static function create(array $referral): self
    {
        $self = new self($referral['source'], $referral['type'], $referral['ad_id']);
        if (isset($referral['ref'])) {
            $self->setRef($referral['ref']);
        }

        return $self;
    }
}
