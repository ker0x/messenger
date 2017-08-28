<?php

namespace Kerox\Messenger\Model\Callback;

use Kerox\Messenger\Event\EventFactory;

class Entry
{
    const CHANNELS = [
        'messaging',
        'standby'
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
     *
     * @param string $id
     * @param int    $time
     * @param array  $events
     */
    public function __construct(string $id, int $time, array $events)
    {
        $this->id = $id;
        $this->time = $time;
        $this->events = $events;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getTime(): int
    {
        return $this->time;
    }

    /**
     * @return array
     */
    public function getEvents(): array
    {
        return $this->events;
    }

    /**
     * @param array $entry
     *
     * @return \Kerox\Messenger\Model\Callback\Entry
     */
    public static function create(array $entry): Entry
    {
        $events = [];

        foreach (self::CHANNELS as $channel) {
            if (isset($entry[$channel])) {
                foreach ($entry[$channel] as $event) {
                    $events[] = EventFactory::create($event);
                }
            }
        }

        return new static($entry['id'], $entry['time'], $events);
    }
}
