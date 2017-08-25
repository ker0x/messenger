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
        $this->setFirstName($response);
        $this->setLastName($response);
        $this->setProfilePic($response);
        $this->setLocale($response);
        $this->setTimezone($response);
        $this->setGender($response);
        $this->setPaymentEnabled($response);
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
     * @param array $response
     */
    private function setFirstName(array $response)
    {
        if (isset($response[self::FIRST_NAME])) {
            $this->firstName = $response[self::FIRST_NAME];
        }
    }

    /**
     * @return null|string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param array $response
     */
    private function setLastName(array $response)
    {
        if (isset($response[self::LAST_NAME])) {
            $this->lastName = $response[self::LAST_NAME];
        }
    }

    /**
     * @return null|string
     */
    public function getProfilePic()
    {
        return $this->profilePic;
    }

    /**
     * @param array $response
     */
    private function setProfilePic(array $response)
    {
        if (isset($response[self::PROFILE_PIC])) {
            $this->profilePic = $response[self::PROFILE_PIC];
        }
    }

    /**
     * @return null|string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param array $response
     */
    private function setLocale(array $response)
    {
        if (isset($response[self::LOCALE])) {
            $this->locale = $response[self::LOCALE];
        }
    }

    /**
     * @return null|int
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * @param array $response
     */
    private function setTimezone(array $response)
    {
        if (isset($response[self::TIMEZONE])) {
            $this->timezone = $response[self::TIMEZONE];
        }
    }

    /**
     * @return null|string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param array $response
     */
    private function setGender(array $response)
    {
        if (isset($response[self::GENDER])) {
            $this->gender = $response[self::GENDER];
        }
    }

    /**
     * @return null|bool
     */
    public function isPaymentEnabled()
    {
        return $this->paymentEnabled;
    }

    /**
     * @param array $response
     */
    private function setPaymentEnabled(array $response)
    {
        if (isset($response[self::IS_PAYMENT_ENABLED])) {
            $this->paymentEnabled = $response[self::IS_PAYMENT_ENABLED];
        }
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
