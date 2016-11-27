<?php
namespace Kerox\Messenger\Model\Callback;

class Postback
{

    /**
     * @var string
     */
    protected $payload;

    /**
     * @var null|\Kerox\Messenger\Model\Callback\Referral
     */
    protected $referral;

    /**
     * Postback constructor.
     *
     * @param string $payload
     * @param \Kerox\Messenger\Model\Callback\Referral $referral
     */
    public function __construct(string $payload, Referral $referral = null)
    {
        $this->payload = $payload;
        $this->referral = $referral;
    }

    /**
     * @return string
     */
    public function getPayload(): string
    {
        return $this->payload;
    }

    /**
     * @return null|\Kerox\Messenger\Model\Callback\Referral
     */
    public function getReferral()
    {
        return $this->referral;
    }

    /**
     * @param array $payload
     * @return static
     */
    public static function create(array $payload)
    {
        $referral = isset($payload['referral']) ? Referral::create($payload['referral']) : null;

        return new static($payload['payload'], $referral);
    }
}
