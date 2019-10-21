<?php

namespace App\Module\Shared\Infrastructure\EventStore;

use App\Module\Shared\Domain\AggregateRootId;
use App\Module\Shared\Domain\Event;

interface EventStoreInterface
{
    /**
     * @return EventStoreEvent[]
     */
    public function getEvents(): array;

    public function addEvent(Event $event, string $aggregateClass): void;

    /**
     * @return Event[]
     */
    public function getAggregateEvents(AggregateRootId $id, string $aggregateClass): array;

    public function getAllAggregatesByType(string $aggregate): array;
}