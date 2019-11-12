<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\ProfileSettings;

use Kerox\Messenger\Exception\InvalidTypeException;
use Kerox\Messenger\Helper\UtilityTrait;
use Kerox\Messenger\Helper\ValidatorTrait;

class TargetAudience implements \JsonSerializable
{
    use UtilityTrait;
    use ValidatorTrait;

    private const AUDIENCE_TYPE_ALL = 'all';
    private const AUDIENCE_TYPE_CUSTOM = 'custom';
    private const AUDIENCE_TYPE_NONE = 'none';

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
     * @throws \Kerox\Messenger\Exception\MessengerException
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
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return \Kerox\Messenger\Model\ProfileSettings\TargetAudience
     */
    public static function create(
        string $audienceType = self::AUDIENCE_TYPE_ALL,
        array $whitelistCountries = [],
        array $blacklistCountries = []
    ): self {
        return new self($audienceType, $whitelistCountries, $blacklistCountries);
    }

    /**
     * @throws \Kerox\Messenger\Exception\MessengerException
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
     * @throws \Kerox\Messenger\Exception\MessengerException
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
     * @throws \Kerox\Messenger\Exception\MessengerException
     */
    private function isValidCountries(array $countries): void
    {
        if (!empty($countries)) {
            foreach ($countries as $country) {
                $this->isValidCountry($country);
            }
        }
    }

    /**
     * @throws \Kerox\Messenger\Exception\MessengerException
     */
    private function isValidAudienceType(string $audienceType): void
    {
        $allowedAudienceType = $this->getAllowedAudienceType();
        if (!\in_array($audienceType, $allowedAudienceType, true)) {
            throw new InvalidTypeException(sprintf('audienceType must be either "%s".', implode(', ', $allowedAudienceType)));
        }
    }

    private function getAllowedAudienceType(): array
    {
        return [
            self::AUDIENCE_TYPE_ALL,
            self::AUDIENCE_TYPE_CUSTOM,
            self::AUDIENCE_TYPE_NONE,
        ];
    }

    public function toArray(): array
    {
        $array = [
            'audience_type' => $this->audienceType,
            'countries' => [
                'whitelist' => $this->whitelistCountries,
                'blacklist' => $this->blacklistCountries,
            ],
        ];

        return $this->arrayFilter($array);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
