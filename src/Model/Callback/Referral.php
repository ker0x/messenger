<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Callback;

class Referral
{
    /**
     * @var mixed
     */
    protected $ref;

    /**
     * @var null|string
     */
    protected $source;

    /**
     * @var null|string
     */
    protected $type;

    /**
     * Referral constructor.
     *
     * @param $ref
     * @param null|string $source
     * @param null|string $type
     */
    public function __construct($ref, ?string $source, ?string $type)
    {
        $this->ref = $ref;
        $this->source = $source;
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * @return null|string
     */
    public function getSource(): ?string
    {
        return $this->source;
    }

    /**
     * @return null|string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param array $callbackData
     *
     * @return \Kerox\Messenger\Model\Callback\Referral
     */
    public static function create(array $callbackData): self
    {
        $ref = $callbackData['ref'] ?? null;
        $source = $callbackData['source'] ?? null;
        $type = $callbackData['type'] ?? null;

        return new self($ref, $source, $type);
    }
}
