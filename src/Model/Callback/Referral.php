<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Callback;

class Referral
{
    /**
     * @var string|null
     */
    protected $ref;

    /**
     * @var string|null
     */
    protected $source;

    /**
     * @var string|null
     */
    protected $type;

    /**
     * Referral constructor.
     *
     * @param string|null $ref
     * @param string|null $source
     * @param string|null $type
     */
    public function __construct(?string $ref, ?string $source, ?string $type)
    {
        $this->ref = $ref;
        $this->source = $source;
        $this->type = $type;
    }

    /**
     * @return string|null
     */
    public function getRef(): ?string
    {
        return $this->ref;
    }

    /**
     * @return string|null
     */
    public function getSource(): ?string
    {
        return $this->source;
    }

    /**
     * @return string|null
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
