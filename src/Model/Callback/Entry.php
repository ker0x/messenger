<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Callback;

use Kerox\Messenger\Event\EventFactory;

class Entry
{
    private const CHANNELS = [
        'messaging',
        'standby',
    ];

    /**
     * @var string
     */
    protected $id;

    /**
     * @var int
     */
    protected $time;

    /**
     * @var array
     */
    protected $events;

    /**
     * Entry constructor.
     */
    public function __construct(string $id, int $time, array $events)
    {
        $this->id = $id;
        $this->time = $time;
        $this->events = $events;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTime(): int
    {
        return $this->time;
    }

    public function getEvents(): array
    {
        return $this->events;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\Entry
     */
    public static function create(array $entry): self
    {
        $events = [];

        foreach (self::CHANNELS as $channel) {
            if (isset($entry[$channel])) {
                foreach ($entry[$channel] as $event) {
                    $events[] = EventFactory::create($event);
                }
            }
        }

        return new self($entry['id'], $entry['time'], $events);
    }
}
