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
     * @param string $status
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
     * @return null|string
     */
    public function getAuthorizationCode()
    {
        return $this->authorizationCode;
    }

    /**
     * @param array $payload
     * @return static
     */
    public static function create(array $payload)
    {
        $authorizationCode = $payload['authorization_code'] ?? null;

        return new static($payload['status'], $authorizationCode);
    }
}
