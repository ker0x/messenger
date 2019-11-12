<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\ProfileSettings;

class IceBreakers implements \JsonSerializable
{
    /**
     * @var string
     */
    protected $question;

    /**
     * @var string
     */
    protected $payload;

    /**
     * IceBreakers constructor.
     */
    public function __construct(string $question, string $payload)
    {
        $this->question = $question;
        $this->payload = $payload;
    }

    /**
     * @return \Kerox\Messenger\Model\ProfileSettings\IceBreakers
     */
    public static function create(string $question, string $payload): self
    {
        return new self($question, $payload);
    }

    public function toArray(): array
    {
        return [
            'question' => $this->question,
            'payload' => $this->payload,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
