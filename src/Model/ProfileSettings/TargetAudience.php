<?php

namespace Kerox\Messenger\Model\ProfileSettings;

use Kerox\Messenger\Helper\UtilityTrait;
use Kerox\Messenger\Helper\ValidatorTrait;

class TargetAudience implements \JsonSerializable
{
    use UtilityTrait;
    use ValidatorTrait;

    const AUDIENCE_TYPE_ALL = 'all';
    const AUDIENCE_TYPE_CUSTOM = 'custom';
    const AUDIENCE_TYPE_NONE = 'none';

    /**
     * @var string
     */
    protected $audienceType;

    /**
     * @var array
     */
    protected $whitelistCountries;

    /**
     * @var array
     */
    protected $blacklistCountries;

    /**
     * TargetAudience constructor.
     *
     * @param string $audienceType
     * @param array  $whitelistCountries
     * @param array  $blacklistCountries
     */
    public function __construct(
        string $audienceType = self::AUDIENCE_TYPE_ALL,
        array $whitelistCountries = [],
        array $blacklistCountries = []
    ) {
        $this->isValidAudienceType($audienceType);
        $this->isValidCountries($whitelistCountries);
        $this->isValidCountries($blacklistCountries);

        $this->audienceType = $audienceType;
        $this->whitelistCountries = $whitelistCountries;
        $this->blacklistCountries = $blacklistCountries;
    }

    /**
     * @param string $country
     *
     * @throws \InvalidArgumentException
     *
     * @return \Kerox\Messenger\Model\ProfileSettings\TargetAudience
     */
    public function addWhitelistCountry(string $country): self
    {
        $this->isValidCountry($country);

        $this->whitelistCountries[] = $country;

        return $this;
    }

    /**
     * @param string $country
     *
     * @throws \InvalidArgumentException
     *
     * @return \Kerox\Messenger\Model\ProfileSettings\TargetAudience
     */
    public function addBlacklistCountry(string $country): self
    {
        $this->isValidCountry($country);

        $this->blacklistCountries[] = $country;

        return $this;
    }

    /**
     * @param array $countries
     *
     * @throws \InvalidArgumentException
     */
    private function isValidCountries(array $countries)
    {
        if (!empty($countries)) {
            foreach ($countries as $country) {
                $this->isValidCountry($country);
            }
        }
    }

    /**
     * @param string $audienceType
     *
     * @throws \InvalidArgumentException
     */
    private function isValidAudienceType(string $audienceType)
    {
        $allowedAudienceType = $this->getAllowedAudienceType();
        if (!in_array($audienceType, $allowedAudienceType, true)) {
            throw new \InvalidArgumentException('$audienceType must be either ' . implode(', ', $allowedAudienceType));
        }
    }

    /**
     * @return array
     */
    private function getAllowedAudienceType(): array
    {
        return [
            self::AUDIENCE_TYPE_ALL,
            self::AUDIENCE_TYPE_CUSTOM,
            self::AUDIENCE_TYPE_NONE,
        ];
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = [
            'audience_type' => $this->audienceType,
            'countries'     => [
                'whitelist' => $this->whitelistCountries,
                'blacklist' => $this->blacklistCountries,
            ],
        ];

        return $this->arrayFilter($json);
    }
}
