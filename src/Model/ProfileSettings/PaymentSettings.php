<?php
namespace Kerox\Messenger\Model\ProfileSettings;

use Kerox\Messenger\Helper\ValidatorTrait;

class PaymentSettings implements \JsonSerializable
{

    use ValidatorTrait;

    /**
     * @var null|string
     */
    protected $privacyUrl;

    /**
     * @var null|string
     */
    protected $publicKey;

    /**
     * @var array
     */
    protected $testUsers = [];

    /**
     * @param string $privacyUrl
     * @return \Kerox\Messenger\Model\ProfileSettings\PaymentSettings
     */
    public function setPrivacyUrl(string $privacyUrl): PaymentSettings
    {
        $this->isValidUrl($privacyUrl);
        $this->privacyUrl = $privacyUrl;

        return $this;
    }

    /**
     * @param string $publicKey
     * @return \Kerox\Messenger\Model\ProfileSettings\PaymentSettings
     */
    public function setPublicKey(string $publicKey): PaymentSettings
    {
        $this->publicKey = $publicKey;

        return $this;
    }

    /**
     * @param int $testUser
     * @return \Kerox\Messenger\Model\ProfileSettings\PaymentSettings
     */
    public function addTestUser(int $testUser): PaymentSettings
    {
        $this->testUsers[] = $testUser;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = [
            'privacy_url' => $this->privacyUrl,
            'public_key' => $this->publicKey,
            'test_users' => $this->testUsers,
        ];

        return array_filter($json);
    }
}
