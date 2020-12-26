<?php

declare(strict_types=1);

namespace Kerox\Messenger\Event;

use Kerox\Messenger\Model\Callback\AppRoles;

final class AppRolesEvent extends AbstractEvent
{
    public const NAME = 'app_roles';

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
     */
    public function __construct(string $senderId, string $recipientId, int $timestamp, AppRoles $appRoles)
    {
        parent::__construct($senderId, $recipientId);

        $this->timestamp = $timestamp;
        $this->appRoles = $appRoles;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getAppRoles(): AppRoles
    {
        return $this->appRoles;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    /**
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
