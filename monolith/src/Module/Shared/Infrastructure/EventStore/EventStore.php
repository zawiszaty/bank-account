<?php
declare(strict_types=1);


namespace App\Module\Shared\Infrastructure\EventStore;


use App\Module\Shared\Domain\Event;

final class EventStore
{
    /** @var Event[] */
    private $events;

    public function __construct(array $events)
    {
        $this->events = $events;
    }

    /**
     * @return Event[]
     */
    public function getEvents(): array
    {
        return $this->events;
    }

    public function addEvent(Event $event): void
    {
        $this->events[] = $event;
    }
}