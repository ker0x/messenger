<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model;

use Kerox\Messenger\Helper\ValidatorTrait;
use Kerox\Messenger\Model\ProfileSettings\HomeUrl;
use Kerox\Messenger\Model\ProfileSettings\PaymentSettings;
use Kerox\Messenger\Model\ProfileSettings\TargetAudience;

class ProfileSettings implements \JsonSerializable
{
    use ValidatorTrait;

    /**
     * @var array|null
     */
    protected $startButton;

    /**
     * @var \Kerox\Messenger\Model\ProfileSettings\Greeting[]|null
     */
    protected $greetings;

    /**
     * @var \Kerox\Messenger\Model\ProfileSettings\IceBreakers[]|null
     */
    protected $iceBreakers;

    /**
     * @var \Kerox\Messenger\Model\ProfileSettings\PersistentMenu[]|null
     */
    protected $persistentMenus;

    /**
     * @var array|null
     */
    protected $whitelistedDomains;

    /**
     * @var string|null
     */
    protected $accountLinkingUrl;

    /**
     * @var \Kerox\Messenger\Model\ProfileSettings\PaymentSettings|null
     */
    protected $paymentSettings;

    /**
     * @var \Kerox\Messenger\Model\ProfileSettings\HomeUrl|null
     */
    protected $homeUrl;

    /**
     * @var \Kerox\Messenger\Model\ProfileSettings\TargetAudience|null
     */
    protected $targetAudience;

    /**
     * @return \Kerox\Messenger\Model\ProfileSettings
     */
    public static function create(): self
    {
        return new self();
    }

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
     * @throws \Exception
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
     * @param \Kerox\Messenger\Model\ProfileSettings\IceBreakers[] $iceBreakers
     *
     * @return \Kerox\Messenger\Model\ProfileSettings
     */
    public function addIceBreakers(array $iceBreakers): self
    {
        $this->iceBreakers = $iceBreakers;

        return $this;
    }

    /**
     * @throws \Exception
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
     * @throws \Exception
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
     * @deprecated Since version 3.3.0 and will be removed in version 4.0.0.
     *
     * @return \Kerox\Messenger\Model\ProfileSettings
     */
    public function addPaymentSettings(PaymentSettings $paymentSettings): self
    {
        $this->paymentSettings = $paymentSettings;

        return $this;
    }

    /**
     * @return \Kerox\Messenger\Model\ProfileSettings
     */
    public function addHomeUrl(HomeUrl $homeUrl): self
    {
        $this->homeUrl = $homeUrl;

        return $this;
    }

    /**
     * @deprecated Since version 3.3.0 and will be removed in version 4.0.0.
     *
     * @return \Kerox\Messenger\Model\ProfileSettings
     */
    public function addTargetAudience(TargetAudience $targetAudience): self
    {
        $this->targetAudience = $targetAudience;

        return $this;
    }

    /**
     * @throws \Exception
     */
    private function isValidDomains(array $domains): void
    {
        $this->isValidArray($domains, 50);

        foreach ($domains as $domain) {
            $this->isValidUrl($domain);
        }
    }

    public function toArray(): array
    {
        $array = [
            'get_started' => $this->startButton,
            'greeting' => $this->greetings,
            'ice_breakers' => $this->iceBreakers,
            'persistent_menu' => $this->persistentMenus,
            'payment_settings' => $this->paymentSettings,
            'whitelisted_domains' => $this->whitelistedDomains,
            'account_linking_url' => $this->accountLinkingUrl,
            'home_url' => $this->homeUrl,
            'target_audience' => $this->targetAudience,
        ];

        return array_filter($array);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
