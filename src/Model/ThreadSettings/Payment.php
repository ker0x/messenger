<?php
namespace Kerox\Messenger\Model\ThreadSettings;

use Kerox\Messenger\Model\ThreadSettings;

/**
 * @deprecated since 1.2.0 and will be remove in 1.3.0.
 * @see \Kerox\Messenger\Model\ProfileSettings\PaymentSettings
 */
class Payment extends ThreadSettings implements ActionTypeInterface
{

    /**
     * @var null|string
     */
    protected $privacyUrl;

    /**
     * @var null|string
     */
    protected $publicKey;

    /**
     * @var null|string
     */
    protected $devModeAction;

    /**
     * @var null|array
     */
    protected $testers = [];

    /**
     * Payment constructor.
     */
    public function __construct()
    {
        parent::__construct(ThreadSettings::TYPE_PAYMENT);
    }

    /**
     * @param string $privacyUrl
     */
    public function setPrivacyUrl(string $privacyUrl)
    {
        $this->isValidUrl($privacyUrl);
        $this->privacyUrl = $privacyUrl;
    }

    /**
     * @param string $publicKey
     */
    public function setPublicKey(string $publicKey)
    {
        $this->publicKey = $publicKey;
    }

    /**
     * @param string $tester
     */
    public function addTester(string $tester)
    {
        $this->testers[] = $tester;
        $this->setDevModeAction(ActionTypeInterface::ADD);
    }

    /**
     * @param string $tester
     */
    public function removeTester(string $tester)
    {
        $this->testers[] = $tester;
        $this->setDevModeAction(ActionTypeInterface::REMOVE);
    }

    /**
     * @param string $devModeAction
     */
    private function setDevModeAction(string $devModeAction)
    {
        if ($this->devModeAction === null) {
            $this->devModeAction = strtoupper($devModeAction);
        }
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = parent::jsonSerialize();
        $json += [
            'payment_privacy_url' => $this->privacyUrl,
            'payment_public_key' => $this->publicKey,
            'payment_dev_mode_action' => $this->devModeAction,
            'payment_testers' => $this->testers,
        ];

        return array_filter($json);
    }
}
