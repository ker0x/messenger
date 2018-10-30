<?php

declare(strict_types=1);

namespace Kerox\Messenger\Response;

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
     * @var null|float
     */
    protected $timezone;

    /**
     * @var null|string
     */
    protected $gender;

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
     * @return null|float
     */
    public function getTimezone(): ?float
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
}
