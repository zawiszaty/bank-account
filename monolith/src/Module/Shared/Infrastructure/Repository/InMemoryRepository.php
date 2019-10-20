<?php
declare(strict_types=1);


namespace App\Module\Shared\Infrastructure\Repository;


use App\Module\Shared\Domain\AggregateRoot;
use App\Module\Shared\Domain\AggregateRootId;
use App\Module\Shared\Domain\Event;
use App\Module\Shared\Infrastructure\EventStore\EventStore;

class InMemoryRepository
{
    /** @var EventStore */
    private $eventsStore;

    /** @var Event[] */
    protected $unCommittedEvents;

    /** @var string */
    protected $aggregate;

    public function __construct(EventStore $eventsStore)
    {
        $this->eventsStore       = $eventsStore;
        $this->unCommittedEvents = [];
    }

    public function save(): void
    {
        array_map(function (Event $event) {
            $this->eventsStore->addEvent($event, $this->aggregate);
        }, $this->unCommittedEvents);
    }

    protected function getAggregate(AggregateRootId $id): AggregateRoot
    {
        $events    = $this->eventsStore->getAggregateEvents($id, $this->aggregate);
        $aggregate = call_user_func($this->aggregate . '::restore', $events);

        return $aggregate;
    }

    /**
     * @param string $type
     *
     * @return AggregateRoot[]
     */
    protected function getAllAggregatesByType(string $type): array
    {
        return $this->eventsStore->getAllAggregatesByType($this->aggregate);
    }
}