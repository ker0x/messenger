<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Callback;

class AppRoles
{
    /**
     * @var array
     */
    protected $appRoles = [];

    /**
     * AppRoles constructor.
     */
    public function __construct(array $appRoles)
    {
        $this->appRoles = $appRoles;
    }

    public function getAppRoles(): array
    {
        return $this->appRoles;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\AppRoles
     */
    public static function create(array $callbackData): self
    {
        return new self($callbackData);
    }
}
