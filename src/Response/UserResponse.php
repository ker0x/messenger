<?php

declare(strict_types=1);

namespace Kerox\Messenger\Response;

use Kerox\Messenger\Model\Referral;
use Kerox\Messenger\UserInterface;

class UserResponse extends AbstractResponse implements UserInterface
{
    /**
     * @var null|string
     */
    protected $firstName;

    /**
     * @var null|string
     */
    protected $lastName;

    /**
     * @var null|string
     */
    protected $profilePic;

    /**
     * @var null|string
     */
    protected $locale;

    /**
     * @var null|int
     */
    protected $timezone;

    /**
     * @var null|string
     */
    protected $gender;

    /**
     * @var null|bool
     */
    protected $paymentEnabled;

    /**
     * @var null|\Kerox\Messenger\Model\Referral
     */
    protected $lastAdReferral;

    /**
     * @param array $response
     */
    protected function parseResponse(array $response): void
    {
        $this->firstName = $response[UserInterface::FIRST_NAME] ?? null;
        $this->lastName = $response[UserInterface::LAST_NAME] ?? null;
        $this->profilePic = $response[UserInterface::PROFILE_PIC] ?? null;
        $this->locale = $response[UserInterface::LOCALE] ?? null;
        $this->timezone = $response[UserInterface::TIMEZONE] ?? null;
        $this->gender = $response[UserInterface::GENDER] ?? null;
        $this->paymentEnabled = $response[UserInterface::IS_PAYMENT_ENABLED] ?? null;

        $this->setLastAdReferral($response);
    }

    /**
     * @return null|string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @return null|string
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @return null|string
     */
    public function getProfilePic(): ?string
    {
        return $this->profilePic;
    }

    /**
     * @return null|string
     */
    public function getLocale(): ?string
    {
        return $this->locale;
    }

    /**
     * @return null|int
     */
    public function getTimezone(): ?int
    {
        return $this->timezone;
    }

    /**
     * @return null|string
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * @return null|bool
     */
    public function isPaymentEnabled(): ?bool
    {
        return $this->paymentEnabled;
    }

    /**
     * @return null|\Kerox\Messenger\Model\Referral
     */
    public function getLastAdReferral(): ?Referral
    {
        return $this->lastAdReferral;
    }

    /**
     * @param array $response
     */
    private function setLastAdReferral(array $response): void
    {
        if (isset($response[UserInterface::LAST_AD_REFERRAL])) {
            $this->lastAdReferral = Referral::create($response[UserInterface::LAST_AD_REFERRAL]);
        }
    }
}
