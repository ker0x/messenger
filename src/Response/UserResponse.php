<?php

declare(strict_types=1);

namespace Kerox\Messenger\Response;

use Kerox\Messenger\UserInterface;

class UserResponse extends AbstractResponse implements UserInterface
{
    /**
     * @var string|null
     */
    protected $firstName;

    /**
     * @var string|null
     */
    protected $lastName;

    /**
     * @var string|null
     */
    protected $profilePic;

    /**
     * @var string|null
     */
    protected $locale;

    /**
     * @var float|null
     */
    protected $timezone;

    /**
     * @var string|null
     */
    protected $gender;

    protected function parseResponse(array $response): void
    {
        $this->firstName = $response[UserInterface::FIRST_NAME] ?? null;
        $this->lastName = $response[UserInterface::LAST_NAME] ?? null;
        $this->profilePic = $response[UserInterface::PROFILE_PIC] ?? null;
        $this->locale = $response[UserInterface::LOCALE] ?? null;
        $this->timezone = $response[UserInterface::TIMEZONE] ?? null;
        $this->gender = $response[UserInterface::GENDER] ?? null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getProfilePic(): ?string
    {
        return $this->profilePic;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function getTimezone(): ?float
    {
        return $this->timezone;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }
}
