<?php

namespace Kerox\Messenger\Model;

use Kerox\Messenger\Helper\ValidatorTrait;
use Kerox\Messenger\Model\ProfileSettings\PaymentSettings;
use Kerox\Messenger\Model\ProfileSettings\TargetAudience;

class ProfileSettings implements \JsonSerializable
{
    use ValidatorTrait;

    /**
     * @var null|\Kerox\Messenger\Model\ProfileSettings\PersistentMenu[]
     */
    protected $persistentMenus;

    /**
     * @var null|array
     */
    protected $startButton;

    /**
     * @var null|\Kerox\Messenger\Model\ProfileSettings\Greeting[]
     */
    protected $greetings;

    /**
     * @var null|array
     */
    protected $whitelistedDomains;

    /**
     * @var null|string
     */
    protected $accountLinkingUrl;

    /**
     * @var null|\Kerox\Messenger\Model\ProfileSettings\PaymentSettings
     */
    protected $paymentSettings;

    /**
     * @var null|\Kerox\Messenger\Model\ProfileSettings\TargetAudience
     */
    protected $targetAudience;

    /**
     * @param \Kerox\Messenger\Model\ProfileSettings\PersistentMenu[] $persistentMenus
     *
     * @return \Kerox\Messenger\Model\ProfileSettings
     */
    public function addPersistentMenus(array $persistentMenus): self
    {
        $this->persistentMenus = $persistentMenus;

        return $this;
    }

    /**
     * @param string $payload
     *
     * @throws \InvalidArgumentException
     *
     * @return \Kerox\Messenger\Model\ProfileSettings
     */
    public function addStartButton(string $payload): self
    {
        $this->isValidString($payload, 1000);

        $this->startButton = [
            'payload' => $payload,
        ];

        return $this;
    }

    /**
     * @param \Kerox\Messenger\Model\ProfileSettings\Greeting[] $greetings
     *
     * @return \Kerox\Messenger\Model\ProfileSettings
     */
    public function addGreetings(array $greetings): self
    {
        $this->greetings = $greetings;

        return $this;
    }

    /**
     * @param array $whitelistedDomains
     *
     * @return \Kerox\Messenger\Model\ProfileSettings
     */
    public function addWhitelistedDomains(array $whitelistedDomains): self
    {
        $this->isValidDomains($whitelistedDomains);

        $this->whitelistedDomains = $whitelistedDomains;

        return $this;
    }

    /**
     * @param string $accountLinkingUrl
     *
     * @return \Kerox\Messenger\Model\ProfileSettings
     */
    public function addAccountLinkingUrl(string $accountLinkingUrl): self
    {
        $this->isValidUrl($accountLinkingUrl);

        $this->accountLinkingUrl = $accountLinkingUrl;

        return $this;
    }

    /**
     * @param \Kerox\Messenger\Model\ProfileSettings\PaymentSettings $paymentSettings
     *
     * @return \Kerox\Messenger\Model\ProfileSettings
     */
    public function addPaymentSettings(PaymentSettings $paymentSettings): self
    {
        $this->paymentSettings = $paymentSettings;

        return $this;
    }

    /**
     * @param \Kerox\Messenger\Model\ProfileSettings\TargetAudience $targetAudience
     *
     * @return \Kerox\Messenger\Model\ProfileSettings
     */
    public function addTargetAudience(TargetAudience $targetAudience): self
    {
        $this->targetAudience = $targetAudience;

        return $this;
    }

    /**
     * @param array $domains
     */
    private function isValidDomains(array $domains): void
    {
        $this->isValidArray($domains, 10);

        foreach ($domains as $domain) {
            $this->isValidUrl($domain);
        }
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = [
            'persistent_menu'     => $this->persistentMenus,
            'get_started'         => $this->startButton,
            'greeting'            => $this->greetings,
            'whitelisted_domains' => $this->whitelistedDomains,
            'account_linking_url' => $this->accountLinkingUrl,
            'payment_settings'    => $this->paymentSettings,
            'target_audience'     => $this->targetAudience,
        ];

        return array_filter($json);
    }
}
