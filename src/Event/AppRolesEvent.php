<?php

namespace Kerox\Messenger\Event;

use Kerox\Messenger\Model\Callback\AppRoles;

class AppRolesEvent extends AbstractEvent
{
    const NAME = 'app_roles';

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var \Kerox\Messenger\Model\Callback\AppRoles
     */
    protected $appRoles;

    /**
     * ReadEvent constructor.
     *
     * @param string                                   $senderId
     * @param string                                   $recipientId
     * @param int                                      $timestamp
     * @param \Kerox\Messenger\Model\Callback\AppRoles $appRoles
     */
    public function __construct(string $senderId, string $recipientId, int $timestamp, AppRoles $appRoles)
    {
        parent::__construct($senderId, $recipientId);

        $this->timestamp = $timestamp;
        $this->appRoles = $appRoles;
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\AppRoles
     */
    public function getAppRoles(): AppRoles
    {
        return $this->appRoles;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @param $payload
     *
     * @return \Kerox\Messenger\Event\AppRolesEvent
     */
    public static function create(array $payload): self
    {
        $senderId = isset($payload['sender']) ? $payload['sender']['id'] : '';
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $appRoles = AppRoles::create($payload['app_roles']);

        return new static($senderId, $recipientId, $timestamp, $appRoles);
    }
}
