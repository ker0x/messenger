<?php

namespace Kerox\Messenger\Response;

use Kerox\Messenger\Model\Referral;
use Kerox\Messenger\UserInterface;
use Psr\Http\Message\ResponseInterface;

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
     * UserProfileResponse constructor.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response);
    }

    /**
     * @param array $response
     */
    protected function parseResponse(array $response)
    {
        $this->firstName = $response[self::FIRST_NAME] ?? null;
        $this->lastName = $response[self::LAST_NAME] ?? null;
        $this->profilePic = $response[self::PROFILE_PIC] ?? null;
        $this->profilePic = $response[self::PROFILE_PIC] ?? null;
        $this->locale = $response[self::LOCALE] ?? null;
        $this->timezone = $response[self::TIMEZONE] ?? null;
        $this->gender = $response[self::GENDER] ?? null;
        $this->paymentEnabled = $response[self::IS_PAYMENT_ENABLED] ?? null;

        $this->setLastAdReferral($response);
    }

    /**
     * @return null|string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return null|string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return null|string
     */
    public function getProfilePic()
    {
        return $this->profilePic;
    }

    /**
     * @return null|string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @return null|int
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * @return null|string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @return null|bool
     */
    public function isPaymentEnabled()
    {
        return $this->paymentEnabled;
    }

    /**
     * @return null|\Kerox\Messenger\Model\Referral
     */
    public function getLastAdReferral()
    {
        return $this->lastAdReferral;
    }

    /**
     * @param array $response
     */
    private function setLastAdReferral(array $response)
    {
        if (isset($response[self::LAST_AD_REFERRAL])) {
            $this->lastAdReferral = Referral::create($response[self::LAST_AD_REFERRAL]);
        }
    }
}
