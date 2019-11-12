<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Callback;

class AccountLinking
{
    /**
     * @var string
     */
    protected $status;

    /**
     * @var string|null
     */
    protected $authorizationCode;

    /**
     * AccountLinking constructor.
     */
    public function __construct(string $status, ?string $authorizationCode = null)
    {
        $this->status = $status;
        $this->authorizationCode = $authorizationCode;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function hasAuthorizationCode(): bool
    {
        return $this->authorizationCode !== null;
    }

    public function getAuthorizationCode(): ?string
    {
        return $this->authorizationCode;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\AccountLinking
     */
    public static function create(array $callbackData): self
    {
        $authorizationCode = $callbackData['authorization_code'] ?? null;

        return new self($callbackData['status'], $authorizationCode);
    }
}
