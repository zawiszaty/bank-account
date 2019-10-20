<?php
declare(strict_types=1);


namespace App\Module\Shared\Infrastructure\EventStore;


use App\Module\Shared\Domain\AggregateRootId;
use App\Module\Shared\Domain\Event;

final class EventStore
{
    /** @var EventStoreEvent[] */
    private $events;

    /**
     * @return EventStoreEvent[]
     */
    public function getEvents(): array
    {
        return $this->events;
    }

    public function addEvent(Event $event, string $aggregateClass): void
    {
        $this->events[] = new EventStoreEvent(
            $event->getId(),
            serialize($event),
            $aggregateClass
        );
    }

    /**
     * @return Event[]
     */
    public function getAggregateEvents(AggregateRootId $id, string $aggregateClass): array
    {
        $events = [];

        foreach ($this->events as $event)
        {
            if ($this->isCorrectAggregateEvent($id, $aggregateClass, $event))
            {
                $events[] = unserialize($event->getBody());
            }
        }

        return $events;
    }

    private function isCorrectAggregateEvent(AggregateRootId $id, string $aggregateClass, EventStoreEvent $event): bool
    {
        return $event->getId()->toString() === $id->toString() && $event->getAggregate() === $aggregateClass;
    }

    public function getAllAggregatesByType(string $aggregate)
    {
        $aggregateIds = [];

        foreach ($this->events as $event)
        {
            if ($event->getAggregate() === $aggregate)
            {
                $aggregateIds[] = $event->getId()->toString();
            }
        }
        $aggregates = [];
        foreach ($aggregateIds as $id)
        {
          $aggregates[] = $aggregate = call_user_func($this->aggregate . '::restore', $events);
        }
    }
}