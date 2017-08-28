<?php

namespace Kerox\Messenger\Model\Callback;

class AppRoles
{
    /**
     * @var array
     */
    protected $appRoles = [];

    /**
     * AppRoles constructor.
     *
     * @param array $appRoles
     */
    public function __construct(array $appRoles)
    {
        $this->appRoles = $appRoles;
    }

    /**
     * @return array
     */
    public function getAppRoles(): array
    {
        return $this->appRoles;
    }

    /**
     * @param array $payload
     *
     * @return \Kerox\Messenger\Model\Callback\AppRoles
     */
    public static function create(array $payload): AppRoles
    {
        return new static($payload);
    }
}
