<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\ProfileSettings;

use Kerox\Messenger\Helper\ValidatorTrait;

class PaymentSettings implements \JsonSerializable
{
    use ValidatorTrait;

    /**
     * @var string|null
     */
    protected $privacyUrl;

    /**
     * @var string|null
     */
    protected $publicKey;

    /**
     * @var array
     */
    protected $testUsers = [];

    /**
     * @return \Kerox\Messenger\Model\ProfileSettings\PaymentSettings
     */
    public static function create(): self
    {
        return new self();
    }

    /**
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return \Kerox\Messenger\Model\ProfileSettings\PaymentSettings
     */
    public function setPrivacyUrl(string $privacyUrl): self
    {
        $this->isValidUrl($privacyUrl);
        $this->privacyUrl = $privacyUrl;

        return $this;
    }

    /**
     * @return \Kerox\Messenger\Model\ProfileSettings\PaymentSettings
     */
    public function setPublicKey(string $publicKey): self
    {
        $this->publicKey = $publicKey;

        return $this;
    }

    /**
     * @return \Kerox\Messenger\Model\ProfileSettings\PaymentSettings
     */
    public function addTestUser(int $testUser): self
    {
        $this->testUsers[] = $testUser;

        return $this;
    }

    public function toArray(): array
    {
        $array = [
            'privacy_url' => $this->privacyUrl,
            'public_key' => $this->publicKey,
            'test_users' => $this->testUsers,
        ];

        return array_filter($array);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
