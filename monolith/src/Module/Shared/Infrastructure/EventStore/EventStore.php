<?php

declare(strict_types=1);

namespace App\Module\Shared\Infrastructure\EventStore;

use App\Module\Shared\Domain\AggregateRoot;
use App\Module\Shared\Domain\AggregateRootId;
use App\Module\Shared\Domain\Event;

final class EventStore implements EventStoreInterface
{
    /** @var EventStoreEvent[] */
    private $events;

    public function __construct()
    {
        $this->events = [];
    }

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

        foreach ($this->events as $event) {
            if ($this->isCorrectAggregateEvent($id, $aggregateClass, $event)) {
                $events[] = unserialize($event->getBody());
            }
        }

        return $events;
    }

    private function isCorrectAggregateEvent(AggregateRootId $id, string $aggregateClass, EventStoreEvent $event): bool
    {
        return $event->getId()->toString() === $id->toString() && $event->getAggregate() === $aggregateClass;
    }

    public function getAllAggregatesByType(string $aggregate): array
    {
        /** @var EventStoreEvent[] $aggregateEvents */
        $aggregateEvents = [];

        foreach ($this->events as $event) {
            if ($event->getAggregate() === $aggregate) {
                $aggregateEvents[$event->getId()->toString()][] = unserialize($event->getBody());
            }
        }
        $aggregates = [];

        /**
         * @var
         * @var EventStoreEvent $aggregateEvent
         */
        foreach ($aggregateEvents as $id => $aggregateEvent) {
            $aggregates[] = call_user_func($aggregate.'::restore', $aggregateEvents[$id]);
        }

        return $aggregates;
    }

    public function getAggregate(AggregateRootId $withId, string $aggregate): AggregateRoot
    {
        /** @var EventStoreEvent[] $aggregateEvents */
        $aggregateEvents = [];

        foreach ($this->events as $event) {
            if ($event->getAggregate() === $aggregate && $event->getId()->toString() === $withId->toString()) {
                $aggregateEvents[$event->getId()->toString()][] = unserialize($event->getBody());
            }
        }

        /**
         * @var EventStoreEvent $aggregateEvent
         */
        foreach ($aggregateEvents as $id => $aggregateEvent) {
            $aggregate = call_user_func($aggregate.'::restore', $aggregateEvents[$id]);
        }

        return $aggregate;
    }
}
