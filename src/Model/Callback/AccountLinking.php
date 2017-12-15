<?php

namespace Kerox\Messenger\Model\Callback;

class AccountLinking
{
    /**
     * @var string
     */
    protected $status;

    /**
     * @var null|string
     */
    protected $authorizationCode;

    /**
     * AccountLinking constructor.
     *
     * @param string      $status
     * @param string|null $authorizationCode
     */
    public function __construct(string $status, string $authorizationCode = null)
    {
        $this->status = $status;
        $this->authorizationCode = $authorizationCode;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return bool
     */
    public function hasAuthorizationCode(): bool
    {
        return $this->authorizationCode !== null;
    }

    /**
     * @return null|string
     */
    public function getAuthorizationCode()
    {
        return $this->authorizationCode;
    }

    /**
     * @param array $callbackData
     *
     * @return \Kerox\Messenger\Model\Callback\AccountLinking
     */
    public static function create(array $callbackData): self
    {
        $authorizationCode = $callbackData['authorization_code'] ?? null;

        return new static($callbackData['status'], $authorizationCode);
    }
}
